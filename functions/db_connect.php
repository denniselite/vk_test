<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 23.06.14
 * Time: 20:08
 */


function db_connect($db_name)
{
    $host = "localhost";
    $user = "пользователь";
    $password = "пароль";
    $db = $db_name;

    try {
        $DBH = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $DBH;
}
