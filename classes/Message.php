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
        $limit  = 20;

        // extract overrides
        $allowed    = array('criteria', 'limit', 'offset');
        $paramarray = array_intersect_key($paramarray, array_fill_keys($allowed, true));
        extract($paramarray);

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
