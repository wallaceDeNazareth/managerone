<?php

class TaskController {

    protected $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {

        $task = new Task($this->conn);

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

        $task = new Task($this->conn);
        $tb_return = $task->addTask($title, $description, $creation_date, $status, $user_id);

        $response = [];
        $response['status'] = $tb_return['state'];
        $response['msg'] = $tb_return['mss'];

        echo json_encode($response);
    }

    public function deleteTask($id) {

        $task = new Task($this->conn);
        $mss = $task->deleteTask($id);

        $response = [];
        $response['status'] = 1;
        $response['msg'] = $mss;

        echo json_encode($response);
    }

}
