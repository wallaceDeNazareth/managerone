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

    public static function readItemById($tableName, $colSelect, $colParam, $valColParam) {
        $conn = self::getConnection();
        $query = "SELECT " . $colSelect . " FROM " . $tableName . " WHERE " . $colParam . " = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $valColParam);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /*  public function readUser($id) {

      $query = "SELECT name, email FROM " . $this->table_name . " WHERE id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!empty($row)) {
      $this->setName($row['name']);
      $this->setEmail($row['email']);
      return $this;
      } else {
      $ret = null;
      return $ret;
      }
      } */
}
