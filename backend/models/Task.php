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
    protected $colonneList = 'title, description, creation_date, status, user_id';
    protected $nbCol = 5;
    protected $listAllTasks = [];

    public function __construct($db = null) {
        if (isset($db) && !empty($db)) {
            $this->conn = $db;
        } else {
            $this->conn = Database::getConnection();
        }
    }

    public function __construct1($id, $title, $description, $creation_date, $status, $user_id) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->creation_date = $creation_date;
        $this->status = $status;
        $this->user_id = $user_id;
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

        $stmt = Requete::readAllItems($this->conn, $this->table_name, $this->colonnes, 'ASC', 'ORDER BY title');
        foreach ($stmt AS $task) {
            $this->listAllTasks[] = $task;
        }
        return $this->listAllTasks;
    }

    public function addTask($title, $description, $creation_date, $status, $user_id) {

        $user = new User($this->conn);

        if (!empty($user->readUser($user_id))) {
            try {

                if (Requete::addItem($this->conn, $this->table_name, $this->colonneList, $this->nbCol, array($title, $description, $creation_date, $status, $user_id))) {
                    $mss = 'Task : ' . $title . ' , Description : ' . $description . ' ajouté avec succès !';
                    $state = 1;
                    return ['mss' => $mss, 'state' => $state];
                } else {
                    $state = 0;
                    return ['mss' => "Task non ajoutée", 'state' => $state];
                }
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

        $row = Requete::readItemById($this->conn, $this->table_name, $this->colonnes, 'id', $id);

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

        if (Requete::deleteItem($this->conn, $this->table_name, 'id', $id)) {
            return $msg = $task->title . '(' . $task->description . ') supprimé avec success !';
        } else {
            return $msg = $task->title . '(' . $task->description . ') non supprimé !';
        }
    }

}
