<?php
class DB
{
    static private $login = "root";
    static private $pass = "";
    static protected $address = "localhost";
    static protected $port = "3306";
    static public $db_name = "news";
    static private $conn;

    static public function connect()
    {
        $address = self::$address.":".self::$port;
        $dbname = self::$db_name;
        $login = self::$login;
        $pass = self::$pass;
        self::$conn = new PDO("mysql:host=$address;dbname=$dbname", $login, $pass);
    }

    static public function get_all($table)
    {
        $stmt = self::$conn->prepare("SELECT * FROM ".$table);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function get($table, $where)
    {
        $stmt = self::$conn->prepare("SELECT * FROM ".$table." WHERE ?");
        $stmt->execute(array($where));
        return $stmt->fetchAll();
    }

    static public function set($table, $data_title, $data, $where)
    {
        $stmt = self::$conn->prepare("UPDATE ".$table." SET ? = ? WHERE ?");
        return $stmt->execute(array($data_title, $data, $where));
    }

    static public function add($table, $params_title, $params)
    {
        $stmt = self::$conn->prepare("INSERT INTO ".$table." (?) VALUES (?)");
        $stmt->execute(array($params_title, $params));
        return self::$conn->lastInsertId();
    }

    static public function lastInsertId() {
        return self::$conn->lastInsertId();
    }

    static public function getLastId($table)
    {
        $stmt = self::$conn->prepare("SELECT MAX(`id`) FROM ".$table);
        $stmt->execute();
        return $stmt->fetch()[0];
    }

    static public function query($query)
    {
        $stmt = self::$conn->prepare($query);
        return $stmt->execute();
    }

    static function check_conn(): bool
    {
        return self::$conn === NULL;
    }
}
