<?php

class DB
{
    /**
     * retrieves a database handle
     *
     * @todo pull connection params from a config file
     * @todo stash the connection handle in a public class var
     *
     * @return object PDO instance
     */
    public static function connect()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=logbox', 'logbox', 'logbox');
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $pdo;
    }
}
