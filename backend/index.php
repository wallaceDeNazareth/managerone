<?php

//use \models\User;
require('controllers/UserController.php');
require('controllers/TaskController.php');
//require('models/User.php');


$userC = new UserController();
$taskC = new TaskController();


if (isset($_GET['action']) && $_GET['action'] == 'task/addTask') { // && isset($_GET['title']) && isset($_GET['description']) && isset($_GET['creation_date']) && isset($_GET['status']) && isset($_GET['user_id'])
    echo json_encode($_GET);
    $taskC->addTask($_GET['title'], $_GET['description'], $_GET['creation_date'], $_GET['status'], $_GET['user_id']);
}

if (isset($_GET['action']) && isset($_GET['user_id'])) {
    if ($_GET['action'] == 'user/view') {
        $userC->view($_GET['user_id']);
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'user/addUser' && isset($_GET['name']) && isset($_GET['email'])) {
    $userC->addUser($_GET['name'], $_GET['email']);
} elseif (isset($_GET['action']) && $_GET['action'] == 'user/view' && isset($_GET['id'])) {
    $userC->view($_GET['id']);
} elseif (isset($_GET['action']) && $_GET['action'] == 'task/readAll') {
    $taskC->readAll();
} elseif (isset($_GET['action']) && $_GET['action'] == 'task/home') {

    $taskC->home();
} elseif (isset($_GET['action']) && $_GET['action'] == 'task/deleteTask' && isset($_GET['id'])) {

    $taskC->deleteTask($_GET['id']);
} elseif (isset($_GET['action']) && $_GET['action'] == 'user/deleteUser' && isset($_GET['id'])) {

    $userC->deleteUser($_GET['id']);
} elseif (isset($_GET['action']) && isset($_GET['task_id'])) {
    if ($_GET['action'] == 'task/view') {
        $taskC->view($_GET['task_id']);
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'user/listUser') {
    $userC->listUser();
} elseif (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'user/getUser') { ///[0-9]{1,} 
    $userC->getUser($_GET['id']);
} elseif (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'user/getTasks') {
    $userC->getTasks($_GET['id']);
} else {

    $userC->home();
}