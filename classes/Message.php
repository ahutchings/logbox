<?php

class Message
{
    static public function get_count()
    {
        $db = Logbox::get_db();

        $q = 'SELECT COUNT(1) FROM message';

        $count = $db->query($q)->fetchColumn();

        return $count;
    }

    /**
     * get a message or messages
     *
     * @return array An array of Message objects, or a single Message object, depending on request
     */
    static public function get()
    {
        $db = Logbox::get_db();

        $q = 'SELECT * FROM message ORDER BY sent_at DESC LIMIT 12';

        $messages = $db->query($q, PDO::FETCH_CLASS, __CLASS__);

        return $messages;
    }
}
