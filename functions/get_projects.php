<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 23.06.14
 * Time: 16:03
 */

session_start();
require_once "./db_connect.php";

function get_projects(){

    $STH = db_connect("projects")->prepare("SELECT * FROM projects WHERE worker_id = 0");
    $STH->execute();
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $projects = $STH->fetchAll();
    $projects = array(
        'all' => $projects
    );
    if (!empty($_SESSION['id'])){
        $STH = db_connect("projects")->prepare("SELECT * FROM projects WHERE (worker_id = :id) OR ((author_id = :id) AND (worker_id != 0))");
        $data = array(
            'id' => $_SESSION['id']
        );
        $STH->execute($data);
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $my_worked_projects = $STH->fetchAll();
        $projects['my_work'] = $my_worked_projects;
    }
    echo json_encode($projects);
}

get_projects();