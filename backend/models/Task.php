<?php

class Task {

    private $id;
    private $title;
    private $description;
    private $creation_date;
    private $status;
    private $user_id;
    private $conn;
    private $table_name = 'task';

    // retourne le nom


    public function __construct($db) {
        $this->conn = $db;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCreation_date() {
        return $this->creation_date;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setCreation_date($creation_date) {
        $this->creation_date = $creation_date;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function readAllTask() {
        //select all data
        $query = "SELECT
                    id, title, description, creation_date, status, user_id
                FROM
                    " . $this->table_name . "
                ORDER BY
                    title ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addTask($title, $description, $creation_date, $status, $user_id) {

        try {
            $sql = "INSERT INTO task (title, description, creation_date, status, user_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute(array($title, $description, $creation_date, $status, $user_id));
            return "execution ok !";
        } catch (Exception $e) {
            
            return $e->getMessage();
        }
    }

    public function readTask($id) {

        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function deleteTask($id) {

        $task = $this->readTask($id);

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            return $msg = $task['title'] . '(' . $task['description'] . ') supprimé avec success !';
        } else {
            return $msg = $task['title'] . '(' . $task['description'] . ') non supprimé !';
        }
    }

}
