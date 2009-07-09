<?php

class Messages
{
    public static function get_count()
    {
        $q = 'SELECT COUNT(1) FROM message';

        $count = DB::connect()->query($q)->fetchColumn();

        return $count;
    }

    /**
     * get a message or messages
     *
     * @paramarray array Query parameters
     *
     * @return array An array of Message objects, or a single Message object, depending on request
     */
    public static function get($paramarray = array())
    {
        // defaults
        $where  = array();
        $params = array();
        $limit  = is_numeric(Options::get('pagination')) ? Options::get('pagination') : 20;

        // extract overrides
        $allowed    = array('criteria', 'limit', 'offset', 'page');
        $paramarray = array_intersect_key($paramarray, array_fill_keys($allowed, true));
        extract($paramarray);

        if (isset($page) && is_numeric($page) ) {
            $offset = (intval($page) - 1) * intval($limit);
        }

        if (isset($criteria)) {
            $where[] = "(sender LIKE CONCAT('%',?,'%') OR content LIKE CONCAT('%',?,'%'))";
            $params[] = $criteria;
            $params[] = $criteria;
        }

        $q = "SELECT * FROM message ";

        if (count($where)) {
            $q .= ' WHERE (' . implode(' AND ', $where) . ')';
        }

        $q .= " ORDER BY sent_at DESC";
        $q .= " LIMIT $limit";

        if (isset($offset)) {
            $q .= " OFFSET $offset";
        }

        try {
            $sth = DB::connect()->prepare($q);

            $sth->setFetchMode(PDO::FETCH_CLASS, 'Message', array());

            $sth->execute($params);

            $messages = $sth->fetchAll();
        } catch (PDOException $e) {
            trigger_error($e->getMessage());

            return false;
        }

        return $messages;
    }

    /**
     * initial import action
     *
     * @return null
     */
    public static function import()
    {
        set_time_limit(1000000);

        $q = 'INSERT INTO message (sent_at, protocol, sender, recipient, content)'.
            ' VALUES (FROM_UNIXTIME(:sentat), :protocol, :sender, :recipient, :content)';

        $sth = DB::connect()->prepare($q);

        $protocols = array_diff(scandir(Options::get('log_path')), array('.', '..'));

        foreach ($protocols as $protocol) {
            $protocol_dir = Options::get('log_path') . '/' . $protocol;
            $accounts     = array_diff(scandir($protocol_dir), array('.', '..'));

            foreach ($accounts as $account) {
                $account_dir = $protocol_dir . '/' . $account;
                $recipients = array_diff(scandir($account_dir), array('.', '..'));

                foreach ($recipients as $recipient) {
                    $recipient_dir = $account_dir . '/' . $recipient;
                    $sessions      = array_diff(scandir($recipient_dir), array('.', '..'));

                    foreach ($sessions as $session) {
                        $session_path = $recipient_dir . '/' . $session;

                        $message_regex = '/^\((?P<sentat>.*?)\) (?P<sender>.*?): (?P<content>.*)/';
                        $status_regex  = '/\\((?P<sentat>.*)\\) (?P<sender>.*)\\ (?P<content>.*)/';
                        $session_regex = '/(?P<year>\\d{4})-(?P<month>\\d{2})-(?P<day>\\d{2}).(?P<hour>\\d{2})(?P<minute>\\d{2})(?P<second>\\d{2})/';

                        preg_match($session_regex, $session, $session_match);

                        $session_handle = file($session_path);

                        for ($i = 1, $n = count($session_handle); $i < $n; $i++) {

                            // if we can match a message
                            if (preg_match($message_regex, $session_handle[$i], $message_match) === 1) {

                                // skip failed AIM messages
                                if ($message_match['sender'] == 'Unable to send message') {
                                    continue;
                                }

                                // strip auto-reply text from the sender
                                $message_match['sender'] = str_replace(' <AUTO-REPLY>', '', $message_match['sender']);

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
                                // @todo this is probably a multiline message
                                $log = 'Unknown line type in file %s. Content: %s';
                                trigger_error(sprintf($log, $session_path, $session_handle[$i]), E_USER_WARNING);
                            }
                        }
                    }
                }
            }
        }
    }
}
