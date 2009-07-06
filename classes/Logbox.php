<?php

class Logbox
{
    /**
     * autoload method
     *
     * @param string $class Class name
     *
     * @return null
     */
    static function autoload($class)
    {
        require LOGBOX_PATH . '/classes/' . ucfirst($class) . '.php';
    }

    /**
    * error handler
    *
    * @param int    $level   Error level
    * @param string $message Error message
    * @param string $file    Filename the error was raised in
    * @param int    $line    Line number the error was raised at
    * @param array  $context Existing variables at the time the error was raised
    *
    * @return bool
    */
    static function errorHandler($level, $message, $file, $line, $context)
    {
        $db = self::get_db();

        $q = 'INSERT INTO log (level, file, line, message, created_at)'
            . ' VALUES (?, ?, ?, ?, FROM_UNIXTIME(?))';

        try {
            $sth = $db->prepare($q);

            $file = str_replace(LOGBOX_PATH, '', $file);

            $log = array($level, $file, $line, $message, time());

            $sth->execute($log);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return true;
    }

    /**
     * retrieves a database handle
     *
     * @todo pull connection params from a config file
     *
     * @return object PDO instance
     */
    static function get_db()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=logbox', 'logbox', 'logbox');
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $pdo;
    }

    /**
     * initial import action
     *
     * @return null
     */
    static function import()
    {
        set_time_limit(1000000);

        $db = self::get_db();

        $q = 'INSERT INTO message (sent_at, protocol, sender, recipient, content)'.
            ' VALUES (FROM_UNIXTIME(:sentat), :protocol, :sender, :recipient, :content)';

        $sth = $db->prepare($q);

        // @todo move this into options database table
        $log_dir = 'C:/Users/Andrew/AppData/Roaming/.purple/logs';

        $protocols = array_diff(scandir($log_dir), array('.', '..'));

        foreach ($protocols as $protocol) {
            $protocol_dir = $log_dir . '/' . $protocol;
            $accounts     = array_diff(scandir($protocol_dir), array('.', '..'));

            foreach ($accounts as $account) {
                $account_dir = $protocol_dir . '/' . $account;
                $recipients = array_diff(scandir($account_dir), array('.', '..'));

                foreach ($recipients as $recipient) {
                    $recipient_dir = $account_dir . '/' . $recipient;
                    $sessions      = array_diff(scandir($recipient_dir), array('.', '..'));

                    foreach ($sessions as $session) {
                        $session_path = $recipient_dir . '/' . $session;

                        $message_regex = '/\\((?P<sentat>.*)\\) (?P<sender>.*)\\: (?P<content>.*)/';
                        $status_regex  = '/\\((?P<sentat>.*)\\) (?P<sender>.*)\\ (?P<content>.*)/';
                        $session_regex = '/(?P<year>\\d{4})-(?P<month>\\d{2})-(?P<day>\\d{2}).(?P<hour>\\d{2})(?P<minute>\\d{2})(?P<second>\\d{2})/';

                        preg_match($session_regex, $session, $session_match);

                        $session_handle = file($session_path);

                        for ($i = 1, $n = count($session_handle); $i < $n; $i++) {

                            // if we can match a message
                            if (preg_match($message_regex, $session_handle[$i], $message_match) === 1) {
                                $time = $session_match['year'] . '-' . $session_match['month'] . '-' . $session_match['day']
                                    . '' . $message_match['sentat'];

                                $message = array(
                                    ':sentat'    => strtotime($time),
                                    ':protocol'  => $protocol,
                                    ':sender'    => $message_match['sender'],
                                    ':recipient' => $recipient,
                                    ':content'   => $message_match['content']
                                );

                                try {
                                    $sth->execute($message);
                                } catch (PDOException $e) {
                                    trigger_error($e->getMessage(), E_USER_ERROR);
                                }

                            } elseif (preg_match($status_regex, $session_handle[$i], $status_match) === 1) {
                                trigger_error('Event matched.', E_USER_NOTICE);
                                // @todo save the status change
                            } else {
                                trigger_error('Nothing matched!', E_USER_WARNING);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * retrieves the theme path
     *
     * @todo move this into an options database table
     *
     * @return string
     */
    public static function theme_path()
    {
        return '/themes/default/';
    }

    /**
     * retrieves a time difference in common vernacular
     *
     * @param int|string $time UNIX timestamp or parseable string
     *
     * @return string
     */
    public static function fuzzy_time($time = null)
    {
        $time      = ($time == null) ? time() : $time;
        $timestamp = (is_numeric($time)) ? $time : strtotime($time);
        $elapsed   = time() - $timestamp;

        switch ($elapsed) {
            case ($elapsed < -1209600):
                return 'in ' . ($elapsed = floor(abs($elapsed) / 604800)) . ' week' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < -172800):
                return 'in ' . ($elapsed = floor(abs($elapsed) / 86400)) . ' day' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < -7200):
                return 'in ' . ($elapsed = floor(abs($elapsed) / 3600)) . ' hour' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < -120):
                return 'in ' . ($elapsed = floor(abs($elapsed) / 60)) . ' minute' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < 0):
                return 'in ' . abs($elapsed) . ' second' . (($elapsed == 1) ? '' : 's');
            case ($elapsed < 120):
                return $elapsed . ' second' . (($elapsed == 1) ? '' : 's') . ' ago';
            case ($elapsed < 7200):
                return ($elapsed = floor($elapsed / 60)) . ' minute' . (($elapsed == 1) ? '' : 's') . ' ago';
            case ($elapsed < 172800):
                return ($elapsed = floor($elapsed / 3600)) . ' hour' . (($elapsed == 1) ? '' : 's') . ' ago';
            case ($elapsed < 1209600):
                return ($elapsed = floor($elapsed / 86400)) . ' day' . (($elapsed == 1) ? '' : 's') . ' ago';
            case ($elapsed < 4838400):
                return ($elapsed = floor($elapsed / 604800)) . ' week' . (($elapsed == 1) ? '' : 's') . ' ago';
            default:
                return date('F d, Y', $timestamp);
        }
    }
}
