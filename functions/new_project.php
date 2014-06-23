<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 23.06.14
 * Time: 18:28
 */
session_start();
new_project($_POST['desc'], $_POST['price'], $_SESSION['id']);

function new_project($desc, $price, $user_id)
{
    if (empty($user_id)) {
        echo "FALSE_AUTH";
    } else if ($_SESSION['role_id'] == "2") {
        echo "FALSE_WORKER";
    }
    else {
        $user_id = (int)$user_id;
        $price = (int)$price;

        $host = "localhost";
        $user = "root";
        $password = "kavelin1245";
        $db = "projects";
        try {
            $DBH = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $STH = $DBH->prepare("INSERT INTO projects (projects.author_id, projects.desc, projects.price) VALUES (:author_id, :desc, :price)");
        $data = array(
            'author_id' => $user_id,
            'desc' => $desc,
            'price' => $price
        );
        if ($STH->execute($data)) {
            echo "OK";
        } else {
            var_dump($data);
        }
    }
}