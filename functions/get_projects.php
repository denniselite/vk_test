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
    $data = array();
    if (!isset($_SESSION['id'])){
        $data['id'] = 0;
    } else {
        $data['id'] = $_SESSION['id'];
    }
    $STH = db_connect("projects")->prepare("SELECT * FROM projects WHERE worker_id = 0 AND author_id != :id");
    $STH->execute($data);
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $projects = $STH->fetchAll();
    $projects = array(
        'all' => $projects
    );
    if (!empty($_SESSION['id'])){
        $STH = db_connect("projects")->prepare("
            SELECT
            projects.id, projects.desc, projects.price, projects.author_id, projects.worker_id
            FROM projects
            WHERE (worker_id = :id) OR ((author_id = :id) AND (worker_id != 0))"
        );
        $data = array(
            'id' => $_SESSION['id']
        );
        $STH->execute($data);
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $my_worked_projects = $STH->fetchAll();
        $projects['my_work'] = $my_worked_projects;
        for ($i = 0; $i < count($projects['my_work']); $i++){
            if ($projects['my_work'][$i]['author_id'] == $_SESSION['id']){
                $projects['my_work'][$i]['role'] = "Заказчик";
            }
            if ($projects['my_work'][$i]['worker_id'] == $_SESSION['id']){
                $projects['my_work'][$i]['role'] = "Исполнитель";
            }
            unset($projects['my_work'][$i]['worker_id']);
            unset($projects['my_work'][$i]['author_id']);
        }
    }
    echo json_encode($projects);
}

get_projects();