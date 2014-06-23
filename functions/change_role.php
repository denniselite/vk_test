<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 23.06.14
 * Time: 21:35
 */

session_start();
require_once "./db_connect.php";

change_role();

function change_role(){
    $data = array();
    $STH = db_connect("users")->prepare("UPDATE users SET role_id = :role_id");
    if ($_SESSION['role_id'] == "1"){
        $data['role_id'] = 2;
        $_SESSION['role_id'] = 2;
    } else if ($_SESSION['role_id'] == "2"){
        $data['role_id'] = 1;
        $_SESSION['role_id'] = 1;
    }
    $STH->execute($data);

    $STH = db_connect("users")->prepare("SELECT roles.name FROM roles WHERE id = (SELECT role_id FROM users WHERE id = :id)");
    $data = array ('id' => $_SESSION['id']);
    $STH->execute($data);
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $role = $STH->fetch();
    $_SESSION['role'] = $role['name'];
    setcookie('role_id', $_SESSION['role_id'], time() + 900);
    setcookie('role', $_SESSION['role'], time() + 900);
    return "OK";
}