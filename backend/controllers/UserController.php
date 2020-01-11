<?php

require($_SERVER['DOCUMENT_ROOT'] . '/managerone/backend/models/User.php');
require($_SERVER['DOCUMENT_ROOT'] . '/managerone/backend/models/Task.php');

class UserController {

    protected $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addUser($name = null, $email = null) {

        $user = new User($this->conn);
        $response = ["status" => 0, "msg" => ""];
        if (!empty($name) && !empty($email)) {
            $user->addUser($name, $email);
            $msg = 'User ' . $name . ' , email : ' . $email . ' ajouté avec succes !';
            $response['status'] = 1;
            $response['msg'] = $msg;
            echo json_encode($response);
        } else {
            $message = 'Pas de valeur envoyé !';
            $response['status'] = 0;
            $response['msg'] = $message;
            echo json_encode($response);
        }
    }

    public function listUser() {

        $usr = new User($this->conn);

        $tab = [];
        $stab = [];

        $response = [];
        $msg = "Status Nok";
        $status = 0;

        foreach ($usr->read() AS $user) {
            $stab['id'] = $user['id'];
            $stab['name'] = $user['name'];
            $stab['email'] = $user['email'];
            $tab[] = $stab;
        }

        if (!empty($tab)) {
            $msg = "status ok";
            $status = 1;
        }
        $response['status'] = $status;
        $response['msg'] = $msg;
        $response['data'] = $tab;
        echo json_encode($response);
    }

    public function listusropt() {
        
        $usr = new User($this->conn);

        echo '<option value="0" >*** Choix de l\'User ***</option>';
        foreach ($usr->read() AS $user) {
            if (!empty($user)) {
                echo '<option value="' . $user['id'] . '" > ' . $user['name'] . '</option>';
            } else {
                echo '<option>Aucun reglement enregistré</option>';
            }
        }
    }

    public function getUser($id) {

        $usr = new User($this->conn);
        $util = $usr->readUser($id);

        $tab['name'] = $util->getName();
        $tab['email'] = $util->getEmail();

        $response = [];
        $response['status'] = 1;

        if (!empty($tab)) {
            $response['msg'] = "Status ok";
            $response['status'] = 1;
        } else {
            $response['msg'] = "Status Nok";
            $response['status'] = 0;
        }

        $response['data'] = $tab;

        echo json_encode($response);
    }

    public function getTasks($id) {

        $usr = new User($this->conn);

        $tab = [];
        $stab = [];
        foreach ($usr->listTask($id) AS $lt) {

            $stab['id'] = $lt['id'];
            $stab['title'] = $lt['title'];
            $stab['description'] = $lt['description'];
            $stab['creation_date'] = $lt['creation_date'];
            $stab['status'] = $lt['status'];
            $stab['user_id'] = $lt['user_id'];

            $tab[] = $stab;
        }


        $response = [];
        $response['status'] = 1;

        if (!empty($tab)) {
            $response['msg'] = "Status ok";
        } else {
            $response['status'] = 0;
            $response['msg'] = "Pas Task pour cet user";
        }

        $response['data'] = $tab;

        echo json_encode($response);
    }

    public function deleteUser($id) {

        $user = new User($this->conn);
        $msg = $user->deleteUser($id);

        $response = [];
        $response['status'] = 1;
        $response['msg'] = $msg;

        echo json_encode($response);
    }

}
