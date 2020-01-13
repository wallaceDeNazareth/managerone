<?php

require('Requete.php');

class User {

    protected $id;
    protected $name;
    protected $email;
    protected $conn;
    protected $listUsers = [];
    protected $listUserTasks = [];
    protected $table_name = 'user';
    protected $colonnes = ' * ';

    public function __construct($db = null) {
        if (isset($db) && !empty($db)) {
            $this->conn = $db;
        } else {
            $this->conn = Database::getConnection();
        }
    }

    public function __construct1($id, $name, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function read() {

        $stmt = Requete::readAllItems($this->conn, $this->table_name, $this->colonnes, 'ASC', 'ORDER BY name');
        foreach ($stmt AS $user) {
            $this->listUsers[] = $user;
        }
        return $this->listUsers;
    }

    public function readName() {

        $this->name = Requete::readOneCol($this->conn, $this->table_name, 'name', 'id', $this->id);
    }

    public function readUser($id) {
        $row = Requete::readItemById($this->conn, $this->table_name, $this->colonnes, 'id', $id);
        if (!empty($row)) {
            $this->setName($row['name']);
            $this->setEmail($row['email']);
            return $this;
        } else {
            $ret = null;
            return $ret;
        }
    }

    public function addUser($name, $email) {
        $query = "INSERT INTO user (name, email) VALUES (?, ?)";
        $req = $this->conn->prepare($query);
        $req->execute(array($name, $email));
    }

    public function listTask($id) {

        $stmt = Requete::readAllItems($this->conn, 'task', ' * ', 'ASC', 'ORDER BY title', 'WHERE user_id=', $id);

        foreach ($stmt AS $task) {
            $this->listUserTasks[] = $task;
        }
        return $this->listUserTasks;
    }

    public function countTasks($id) {

        $count = Requete::countRow($this->conn, 'task', 'user_id', $id);
        return $count;
    }

    public function deleteUser($id) {

        $user = $this->readUser($id);

        /** deb supp tasks * */
        foreach ($this->listTask($id) AS $tsk) {
            $taskObj = new Task($this->conn);
            $taskObj->deleteTask($tsk['id']);
        }
        /** fin supp list tasks * */
        /** supp de l'user * */
        if ($this->countTasks($id) == 0) {
          /*  $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);*/
            if (Requete::deleteItem($this->conn, $this->table_name, 'id', $id)) {
                return $msg = $user->name . '(' . $user->email . ') supprimé avec success !';
            } else {
                return $msg = $user->name . '(' . $user->email . ') non supprimé !';
            }
        } else {
            return $msg = $user->name . '(' . $user->email . ') non supprimé car possède encore une liste de tâche !';
        }
        /** fin supp de l'user * */
    }

}
