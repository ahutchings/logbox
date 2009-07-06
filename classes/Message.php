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
     * @paramarray array Query parameters
     *
     * @return array An array of Message objects, or a single Message object, depending on request
     */
    static public function get($paramarray = array())
    {
        $db = Logbox::get_db();

        // defaults
        $where  = array();
        $params = array();
        $limit  = 12;

        if (isset($paramarray['criteria'])) {
            $where[] = "(sender LIKE CONCAT('%',?,'%') OR content LIKE CONCAT('%',?,'%'))";
            $params[] = $paramarray['criteria'];
            $params[] = $paramarray['criteria'];
        }

        $q = "SELECT * FROM message ";

        if (count($where) > 0) {
            $q .= ' WHERE (' . implode(' AND ', $where) . ')';
        }

        $q .= " ORDER BY sent_at DESC LIMIT $limit";

        try {
            $sth = $db->prepare($q);

            $sth->setFetchMode(PDO::FETCH_CLASS, 'Message', array());

            $sth->execute($params);

            $messages = $sth->fetchAll();
        } catch (PDOException $e) {
            trigger_error($e->getMessage());

            return false;
        }

        return $messages;
    }
}
