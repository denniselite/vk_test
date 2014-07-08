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

function test_cash($user_id, $price)
{
    $p = db_connect('users');
    $STH = $p->prepare("
    SELECT :price <= (
      SELECT money FROM users WHERE id = :user_id
    ) as 'result'");
    $data = array(
        'user_id' => $user_id,
        'price' => $price
    );
    $STH->execute($data);
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $data = $STH->fetch();
    if ($data['result'] == 1){
        return true;
    } else{
        return false;
    }
}

function new_project($desc, $price, $user_id)
{
    ini_set('display_errors', 1);
    if (!test_cash($user_id, $price)) {
        echo "NO_MONEY";
    } else if (empty($user_id)) {
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
        if ($u->commit()) {
            $p->commit();
            $_SESSION['money'] -= $price;
            setcookie('money', $_SESSION['money'], time() + 900);
            echo $_SESSION['money'];
        } else {
            var_dump($data);
        }
    }
}