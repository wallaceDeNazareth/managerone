<?php

class Database {

    public static $conn1;

    public static function getConnection() {

        self::$conn1 = null;

        try {
            self::$conn1 = new PDO("mysql:host=localhost;dbname=managerone", "root", "");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return self::$conn1;
    }

}
