<?php

class Task {

    protected $id;
    protected $title;
    protected $description;
    protected $creation_date;
    protected $status;
    protected $user_id;
    protected $conn;
    protected $table_name = 'task';
    protected $colonnes = ' * ';

    public function __construct($db = null) {
        if (isset($db) && !empty($db)) {
            $this->conn = $db;
        } else {
            $this->conn = Database::getConnection();
        }
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

        $user = new User($this->conn);

        if (!empty($user->readUser($user_id))) {
            try {
                $sql = "INSERT INTO task (title, description, creation_date, status, user_id) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);

                $stmt->execute(array($title, $description, $creation_date, $status, $user_id));

                $mss = 'Task : ' . $title . ' , Description : ' . $description . ' ajouté avec succès !';
                $state = 1;

                return ['mss' => $mss, 'state' => $state];
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {

            $mss = 'L\'user n\'existe pas !';
            $state = 0;
            return ['mss' => $mss, 'state' => $state];
        }
    }

    public function readTask($id) {
        
        $row = Database::readItemById($this->table_name, $this->colonnes, 'id', $id);
        if (!empty($row)) {
            $this->setTitle($row['title']);
            $this->setDescription($row['description']);
            $this->setCreation_date($row['creation_date']);
            $this->setStatus($row['status']);
            $this->setUser_id($row['user_id']);
            return $this;
        } else {
            $ret = null;
            return $ret;
        }
    }

    public function deleteTask($id) {

        $task = $this->readTask($id);

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            return $msg = $task->title . '(' . $task->description . ') supprimé avec success !';
        } else {
            return $msg = $task->title . '(' . $task->description . ') non supprimé !';
        }
    }

}
