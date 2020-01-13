<?php

Class Requete {

    public static function readItemById($dbConnexion, $tableName, $colSelect, $colParam, $valColParam) {

        $query = "SELECT " . $colSelect . " FROM " . $tableName . " WHERE " . $colParam . " = ?";
        $stmt = $dbConnexion->prepare($query);
        $stmt->bindParam(1, $valColParam);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public static function readAllItems($dbConnexion, $tableName, $colSelect, $asc_or_desc, $orderByCondition = '', $where_col = '', $whereParamVal = '') {

        $query = "SELECT " . $colSelect . " FROM " . $tableName . " " . $where_col . $whereParamVal . " " . $orderByCondition . " " . $asc_or_desc;
        $stmt = $dbConnexion->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public static function readOneCol($dbConnexion, $tableName, $colName, $where_col, $whereParamVal) {
        $query = "SELECT " . $colName . " FROM " . $tableName . " WHERE " . $where_col . " = ? limit 0,1";
        $stmt = $dbConnexion->prepare($query);
        $stmt->bindParam(1, $whereParamVal);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row[$colName];
    }

    public static function countRow($dbConnexion, $tableName, $where_col, $whereParamVal) {

        $query = "SELECT COUNT(*) FROM " . $tableName . " WHERE " . $where_col . " = ?";

        $stmt = $dbConnexion->prepare($query);
        $stmt->bindValue(1, $whereParamVal);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function deleteItem($dbConnexion, $tableName, $where_col, $whereParamVal) {
        $query = "DELETE FROM " . $tableName . " WHERE " . $where_col . " = ?";
        $stmt = $dbConnexion->prepare($query);
        $stmt->bindParam(1, $whereParamVal);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        /*  $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(1, $id);
          $stmt->execute() */
    }

}
