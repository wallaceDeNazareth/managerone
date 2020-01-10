<?php

require('UserController.php');
require('TaskController.php');

class MainController {

    public function runApp() {

        $userC = new UserController();
        $taskC = new TaskController();


        if (isset($_GET['action'])) {

            if ($_GET['action'] == 'task/addTask') {

                if (isset($_GET['title']) && isset($_GET['description']) && isset($_GET['creation_date']) && isset($_GET['status']) && isset($_GET['user_id']) && !empty($_GET['title']) && !empty($_GET['description']) && !empty($_GET['creation_date']) && !empty($_GET['status']) && !empty($_GET['user_id'])) {
                    
                    $title = htmlentities($_GET['title'], ENT_QUOTES);
                    $description = htmlentities($_GET['description'], ENT_QUOTES);
                    $creation_date = htmlentities($_GET['creation_date'], ENT_QUOTES);
                    $status = htmlentities($_GET['status'], ENT_QUOTES);
                    $user_id = htmlentities($_GET['user_id'], ENT_QUOTES);

                    $taskC->addTask($title, $description, $creation_date, $status, $user_id);
                } else {
                    $response = [];
                    $response['status'] = 0;
                    $response['msg'] = "Mauvaise requete1";
                    echo json_encode($response);
                }
            }


            if ($_GET['action'] == 'task/readAll') {
                $taskC->readAll();
            }

            if ($_GET['action'] == 'user/addUser' && isset($_GET['name']) && isset($_GET['email'])) {
                if (!empty($_GET['name']) && !empty($_GET['email'])) {
                    $name = htmlentities($_GET['name'], ENT_QUOTES);
                    $email = htmlentities($_GET['email'], ENT_QUOTES);
                    $userC->addUser($name, $email);
                } else {
                    $response = [];
                    $response['status'] = 0;
                    $response['msg'] = "Mauvaise requete2";
                    echo json_encode($response);
                }
            } elseif ($_GET['action'] == 'task/readAll') {
                $taskC->readAll();
            } elseif ($_GET['action'] == 'task/deleteTask' && isset($_GET['id'])) {
                if (!empty($_GET['id'])) {
                    $id = htmlentities($_GET['id'], ENT_QUOTES);
                    $taskC->deleteTask($id);
                } else {
                    $response = [];
                    $response['status'] = 0;
                    $response['msg'] = "Mauvaise requete4";
                    echo json_encode($response);
                }
            } elseif ($_GET['action'] == 'user/deleteUser' && isset($_GET['id'])) {
                if (!empty($_GET['id'])) {
                    $id = htmlentities($_GET['id'], ENT_QUOTES);
                    $userC->deleteUser($id);
                } else {
                    $response = [];
                    $response['status'] = 0;
                    $response['msg'] = "Mauvaise requete5";
                    echo json_encode($response);
                }
            } elseif ($_GET['action'] == 'user/listUser') {
                $userC->listUser();
            } elseif (isset($_GET['id']) && $_GET['action'] == 'user/getUser') { ///[0-9]{1,} 
                if (!empty($_GET['id'])) {
                    $id = htmlentities($_GET['id'], ENT_QUOTES);
                    $userC->getUser($id);
                } else {
                    $response = [];
                    $response['status'] = 0;
                    $response['msg'] = "Mauvaise requete6";
                    echo json_encode($response);
                }
            } elseif (isset($_GET['id']) && $_GET['action'] == 'user/getTasks') {
                if (!empty($_GET['id'])) {
                    $id = htmlentities($_GET['id'], ENT_QUOTES);
                    $userC->getTasks($id);
                } else {
                    $response = [];
                    $response['status'] = 0;
                    $response['msg'] = "Mauvaise requete7";
                    echo json_encode($response);
                }
            } else {
                $response = [];
                $response['status'] = 0;
                $response['msg'] = "Mauvaise requete3";
                echo json_encode($response);
            }
        }
    }

}
