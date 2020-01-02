<?php

require($_SERVER['DOCUMENT_ROOT'] . '/managerone/backend/models/User.php');
require($_SERVER['DOCUMENT_ROOT'] . '/managerone/backend/models/Task.php');
require($_SERVER['DOCUMENT_ROOT'] . '/managerone/backend/models/Database.php');

//require ('../view/user/');
class UserController {

    public function view($id) {
       
//        include ($_SERVER['DOCUMENT_ROOT'] . '/managerone/frontend/view.php?id=' . $id);
    }

    public function home() {

//        echo $_SERVER['DOCUMENT_ROOT'].'/managerone/view/user/index.php';
//        include ($_SERVER['DOCUMENT_ROOT'] . '/managerone/backend/view/user/index_user.php');
//        return $this->render('home');
    }

    public function addUser($name = null, $email = null) {
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        $response = ["status" => 0, "msg" => ""];
        if (!empty($name) && !empty($email)) {
//            echo $name . ' ' . $mail;
            $user->addUser($name, $email);
            $msg = 'User ' . $name . ' , email : ' . $email . ' ajouté avec succes !';
            $response['status'] = 1;
            $response['msg'] = $msg;
            echo json_encode($response);
//            header('Location: index.php?action=user/home&message=User ' . $name . ' ajouté avec succes !');
        } else {

            $message = 'Pas de valeur envoyé !';
            $response['status'] = 0;
            $response['msg'] = $message;
            echo json_encode($response);
//            include ($_SERVER['DOCUMENT_ROOT'] . '/managerone/backend/view/user/form_user.php');
        }
    }

    public function listUser() {
        $database = new Database();
        $db = $database->getConnection();
        $usr = new User($db);

        $tab = [];
        $stab = [];

        $response = [];
        $msg = "Status Nok";
        $status = 0;

        foreach ($usr->read() AS $user) {
//            echo $user['name'] . ' ' . $user['email'] . '<br/>';
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

    public function listU() {
        $database = new Database();
        $db = $database->getConnection();
        $usr = new User($db);

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
        $database = new Database();
        $db = $database->getConnection();
        $usr = new User($db);
        $util = $usr->readUser($id);
//        echo $util['name'] . ' ' . $util['email'];

        $tab['name'] = $util['name'];
        $tab['email'] = $util['email'];

        $response = [];
        $response['status'] = 1;

        if (!empty($tab)) {
            $response['msg'] = "Status ok";
        } else {
            $response['msg'] = "Status Nok";
        }

        $response['data'] = $tab;

        echo json_encode($response);
    }

    public function getTasks($id) {
        $database = new Database();
        $db = $database->getConnection();
        $usr = new User($db);

//        echo json_encode($usr);
//        var_dump($usr);

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
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        $msg = $user->deleteUser($id);

        $response = [];
        $response['status'] = 1;
        $response['msg'] = $msg;

        echo json_encode($response);
    }

}
