<?php

class Message
{
    public function get_count()
    {
        $db = Logbox::get_db();

        $q = 'SELECT COUNT(1) FROM message';

        $count = $db->query($q)->fetchColumn();

        return $count;
    }

    public function get()
    {
        $db = Logbox::get_db();

        $q = 'SELECT * FROM message ORDER BY sent_at DESC LIMIT 12';

        $messages = $db->query($q, PDO::FETCH_CLASS, __CLASS__);

        return $messages;
    }
}
