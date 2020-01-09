<?php

class TaskController {

    public function readAll() {
//        $database = new Database();
        $db = Database::getConnection();
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
//        $database = new Database();
        $db = Database::getConnection();
        $task = new Task($db);
        $tb_return = $task->addTask($title, $description, $creation_date, $status, $user_id);
//        $mss = 'Task : ' . $title . ' , Description : ' . $description . ' ajouté avec succès !';

        $response = [];
        $response['status'] = $tb_return['state'];
        $response['msg'] = $tb_return['mss'];

        echo json_encode($response);
    }

    public function deleteTask($id) {
//        $database = new Database();
        $db = Database::getConnection();
        $task = new Task($db);
        $mss = $task->deleteTask($id);

        $response = [];
        $response['status'] = 1;
        $response['msg'] = $mss;

        echo json_encode($response);
    }

}
