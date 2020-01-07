<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TaskController {

    public function view($task_id) {
        /*$task = new Task($task_id);
        var_dump($task);*/
    }

    public function home() {

        include ($_SERVER['DOCUMENT_ROOT'] . '/managerone/view/task/index_task.php');
    }

    public function readAll() {
        $database = new Database();
        $db = $database->getConnection();
        $task = new Task($db);
        $user = new User($db);

//        echo json_encode($task->readAllTask());

        foreach ($task->readAllTask() AS $tsk) {
            $tab_usr = $user->readUser($tsk['user_id']);
            echo $tsk['id'] . ' ' . $tsk['title'] . ' ' . $tsk['description'] . ' '
            . $tsk['creation_date'] . ' ' . $tsk['status'] . ' ' . $tab_usr['name'] . '<br/>';
        }
    }

    public function addTask($title, $description, $creation_date, $status, $user_id) {
        $database = new Database();
        $db = $database->getConnection();
        $task = new Task($db);
        $msg_return = $task->addTask($title, $description, $creation_date, $status, $user_id);
        $mss = 'Task : ' . $title . ' , Description : ' . $description . ' ajouté avec succès !';

        $response = [];
        $response['status'] = 1;
        $response['msg'] = $mss;

        echo json_encode($response);
    }

    public function deleteTask($id) {
        $database = new Database();
        $db = $database->getConnection();
        $task = new Task($db);
        $mss = $task->deleteTask($id);

        $response = [];
        $response['status'] = 1;
        $response['msg'] = $mss;

        echo json_encode($response);
    }

}
