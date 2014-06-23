<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 23.06.14
 * Time: 14:45
 */
$DBH;
function login($login, $pass)
{
    $host = "localhost";
    $user = "root";
    $password = "kavelin1245";
    $db = "users";
    try {
        $DBH = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $STH = $DBH->prepare("SELECT * FROM users WHERE login = :login AND pass = :pass");
    $data = array(
        'login' => $login,
        'pass' => $pass
    );
    $STH->execute($data);
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $user = $STH->fetch();
    if (is_array($user)) {
        if (!empty($user['name']))
            $STH = $DBH->prepare("SELECT * FROM roles WHERE roles.id = :id");
        $data = array(
            'id' => $user['role_id']
        );
        $STH->execute($data);
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $role = $STH->fetch();
        $user['role'] = $role['name'];
        return $user;
    }
}