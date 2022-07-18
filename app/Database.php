<?php

class DB{
    private const username = 'user';
    private const password = 'qwertpoiuy';
    private const db = 'phantom-blog';
    private const host = '127.0.0.1';
    private const dsn = "mysql:host=".self::host.";dbname=".self::db.";charset=utf8";

    private static $db;

    // connects to db and returns array from query
    public static function q($sql){
        return self::getPDO()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPDO()
    {
        if (!isset($db)) {
            $db = new PDO(self::dsn, self::username, self::password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }

    public static function pq($sql, $params)
    {
        $statement = self::getPDO()->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function pu($sql, $params)
    {
        $statement = self::getPDO()->prepare($sql);
        return $statement->execute($params);
    }
}