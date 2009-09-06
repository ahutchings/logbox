<?php

class Pidgin_Plaintext_Importer extends Repository_Importer
{
    /**
     * Imports messages from a Pidgin plain text repository.
     *
     * @return bool
     */
    protected function import()
    {
        $message_regex = '/^\((?P<sentat>.*?)\) (?P<sender>.*?): (?P<content>.*)/';
        $status_regex  = '/\\((?P<sentat>.*)\\) (?P<sender>.*)\\ (?P<content>.*)/';
        $file_regex    = '%/(?P<protocol>.*)/(?P<account>.*)/(?P<recipient>.*)/'
            .'(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2}).(?P<hour>\d{2})(?P<minute>\d{2})(?P<second>\d{2})%';

        foreach (dir::list_files($this->directory) as $path) {

            // standardize path for the regex
            $file = substr($path, strlen(implode(DIRECTORY_SEPARATOR, explode(DIRECTORY_SEPARATOR, $path, -4))));
            $file = str_replace('\\', '/', $file);

            preg_match($file_regex, $file, $file_match);

            // create entry for protocol
            $protocol = ORM::factory('protocol')->where('name', $file_match['protocol'])->find();
            if (!$protocol->loaded) {
                $protocol->name = $file_match['protocol'];
                $protocol->save();
            }

            // create entry for account
            $account = ORM::factory('account')->where('name', $file_match['account'])->find();
            if (!$account->loaded) {
                $account->name = $file_match['account'];
                $account->protocol_id = $protocol->id;
                $account->save();
            }

            // create entry for buddy
            $buddy = ORM::factory('buddy')->where('name', $file_match['recipient'])->find();
            if (!$buddy->loaded) {
                $buddy->name = $file_match['recipient'];
                $buddy->account_id = $account->id;
                $buddy->save();
            }

            // create entry for conversation
            $conv_started_at = date('Y-m-d H:i:s', strtotime(
                $file_match['year'].'-'.$file_match['month'].'-'.$file_match['day'].' '
                .$file_match['hour'].':'.$file_match['minute'].':'.$file_match['second']
            ));

            $conversation = ORM::factory('conversation')
                ->where(array(
                	'account_id' => $account->id,
                	'buddy_id' => $buddy->id,
                    'started_at' => $conv_started_at
                ))
                ->find();

            if (!$conversation->loaded) {
                $conversation->account_id = $account->id;
                $conversation->buddy_id   = $buddy->id;
                $conversation->started_at = $conv_started_at;
                $conversation->save();
            }

            $lines = file($path);

            for ($i = 1, $n = count($lines); $i < $n; $i++) {

                // @todo match file transfers

                // if we can match a message
                if (preg_match($message_regex, $lines[$i], $message_match) === 1) {

                    // skip failed AIM messages
                    if ($message_match['sender'] == 'Unable to send message') {
                        continue;
                    }

                    // strip auto-reply text from the sender
                    $message_match['sender'] = str_replace(' <AUTO-REPLY>', '', $message_match['sender']);

                    // format time
                    $time = $file_match['year'] .'-'. $file_match['month'] .'-'. $file_match['day']
                        .' '. $message_match['sentat'];
                    $time = date('Y-m-d H:i:s', strtotime($time));

                    // save the message
                    $message = new Message_Model();
                    $message->conversation_id = $conversation->id;
                    $message->sent_at   = $time;
                    $message->sender    = $message_match['sender'];
                    $message->recipient = $file_match['recipient'];
                    $message->content   = $message_match['content'];
                    $message->save();

                } elseif (preg_match($status_regex, $lines[$i], $status_match) === 1) {
                    // @todo save the status change
                } else {
                    // @todo this is probably a multiline message
                }
            }
        }
    }
}
