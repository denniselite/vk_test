<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 24.06.14
 * Time: 8:07
 */

session_start();
require_once "./db_connect.php";

get_projects();

function get_projects()
{
    if (($_SESSION['role_id'] === "3")) {
        $STH = db_connect("projects")->prepare("SELECT * FROM projects");
        $STH->execute();
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $projects = $STH->fetchAll();
        for ($i = 0; $i < count($projects); $i++){
            $projects[$i]['author_name'] = get_name($projects[$i]['author_id']);
            if (empty($projects[$i]['worker_id'])){
                $projects[$i]['worker_name'] = "Не сделан";
            } else {
                $projects[$i]['worker_name'] = get_name($projects[$i]['worker_id']);
            }
            unset($projects[$i]['user_id']);
            unset($projects[$i]['worker_id']);
        }
        echo json_encode($projects);
    }
}

function get_name($id){
    $STH = db_connect("users")->prepare("SELECT users.name FROM users WHERE id = :id");
    $data = array(
        'id' => $id
    );
    $STH->execute($data);
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $user = $STH->fetch();
    return $user['name'];
}