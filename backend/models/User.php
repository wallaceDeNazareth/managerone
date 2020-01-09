<?php

class User {

    protected $id;
    protected $name;
    protected $email;
    protected $conn;
    protected $table_name = 'user';

    public function __construct($db) {
        $this->conn = $db;
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

        $query = "SELECT
                    id, name, email
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readName() {

        $query = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
    }

    public function readUser($id) {

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
    }

    public function addUser($name, $email) {
        $query = "INSERT INTO user (name, email) VALUES (?, ?)";
        $req = $this->conn->prepare($query);
        $req->execute(array($name, $email));
    }

    public function listTask($id) {

        $query = "SELECT * FROM task WHERE user_id = ? order by title ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt;
    }

    public function countTasks($id) {
        $query = "SELECT COUNT(*) FROM task WHERE user_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetchColumn();
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
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            if ($stmt->execute()) {
                return $msg = $user['name'] . '(' . $user['email'] . ') supprimé avec success !';
            } else {
                return $msg = $user['name'] . '(' . $user['email'] . ') non supprimé !';
            }
        } else {
            return $msg = $user['name'] . '(' . $user['email'] . ') non supprimé car possède encore une liste de tâche !';
        }
        /** fin supp de l'user * */
    }

}
