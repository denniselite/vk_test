<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 23.06.14
 * Time: 19:22
 */
//ini_set('display_errors', '1');
session_start();
require_once "./db_connect.php";

make_project($_POST['id'], $_SESSION['id'], $_SESSION['role_id']);

function make_project($project_id, $user_id, $role_id)
{
    if (empty($user_id)||($user_id == "")) {
        echo "FALSE_AUTH";
    } else
    if ($role_id == "1") {
        echo "FALSE_WORKER";
    } else {
        $user_id = (int)$user_id;
        $project_id = (int)$project_id;

        $STH = db_connect("projects")->prepare("SELECT price FROM projects WHERE projects.id = :id");
        $data = array(
            'id' => $project_id
        );
        $STH->execute($data);
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $project = $STH->fetch();

        $STH = db_connect("projects")->prepare("UPDATE projects SET worker_id = :worker_id WHERE projects.id = :id");
        $data = array(
            'worker_id' => $user_id,
            'id' => $project_id
        );
        $STH->execute($data);

        $STH = db_connect("users")->prepare("UPDATE users SET money = money + :money WHERE id = :user_id");
        $project['price'] = (double)$project['price'];
        $system_percent = ($project['price'] / 100) * 13;
        $project['price'] -= ($project['price'] / 100) * 13;
        $data = array(
            'user_id' => $user_id,
            'money' => $project['price']
        );
        $STH->execute($data);

        $STH = db_connect("users")->prepare("UPDATE users SET money = money + :money WHERE role_id = 3");
        $data = array(
            'money' => $system_percent
        );
        $STH->execute($data);

        $_SESSION['money'] += $project['price'];
        $_SESSION['money'] = round($_SESSION['money'], 2);
        setcookie('money', $_SESSION['money'], time() + 900);
        echo $_SESSION['money'];
    }
}