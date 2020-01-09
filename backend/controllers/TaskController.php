<?php

class TaskController {

    public function readAll() {

        $db = Database::getConnection();
        $task = new Task($db);
        //$user = new User($db);

        $tab = [];
        $stab = [];
        foreach ($task->readAllTask() AS $tsk) {

            $stab['id'] = $tsk['id'];
            $stab['title'] = $tsk['title'];
            $stab['description'] = $tsk['description'];
            $stab['creation_date'] = $tsk['creation_date'];
            $stab['status'] = $tsk['status'];
            $stab['user_id'] = $tsk['user_id'];

            $tab[] = $stab;
        }


        $response = [];
        $response['status'] = 1;

        if (!empty($tab)) {
            $response['msg'] = "Status ok";
        } else {
            $response['status'] = 0;
            $response['msg'] = "Aucune Task";
        }

        $response['data'] = $tab;

        echo json_encode($response);
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
