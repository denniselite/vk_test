<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 23.06.14
 * Time: 17:13
 */

function logout(){
    session_start();
    unset($_SESSION['id']);
    unset($_SESSION['name']);
    unset($_SESSION['money']);
    unset($_SESSION['role_id']);
    session_destroy();
    header("Location : ./");
}

logout();