<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 23.06.14
 * Time: 18:28
 */
session_start();
require_once "./db_connect.php";
new_project($_POST['desc'], $_POST['price'], $_SESSION['id']);

function new_project($desc, $price, $user_id)
{
    ini_set('display_errors',1);
    if (empty($user_id)) {
        echo "FALSE_AUTH";
    } else if ($_SESSION['role_id'] == "2") {
        echo "FALSE_WORKER";
    } else {
        $user_id = (int)$user_id;
        $p = db_connect('projects');
        $p->beginTransaction();
        $STH = $p->prepare("INSERT INTO projects (projects.author_id, projects.desc, projects.price) VALUES (:author_id, :desc, :price)");
        $data = array(
            'author_id' => $user_id,
            'desc' => $desc,
            'price' => $price
        );
        $STH->execute($data);
        $u = db_connect('users');
        $u->beginTransaction();
        $STH = $u->prepare("UPDATE users SET money = money - :money WHERE id = :user_id");
        $data = array(
            'user_id' => $user_id,
            'money' => $price
        );
        $STH->execute($data);
        if ($u->commit()){
            $p->commit();
            $_SESSION['money'] -= $price;
            setcookie('money', $_SESSION['money'], time() + 900);
            echo $_SESSION['money'];
        } else {
            var_dump($data);
        }
    }
}