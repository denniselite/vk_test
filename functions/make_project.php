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
    if (empty($user_id) || ($user_id == "")) {
        echo "FALSE_AUTH";
    } else
        if ($role_id == "1") {
            echo "FALSE_WORKER";
        } else {
            $user_id = (int)$user_id;
            $project_id = (int)$project_id;
            $p = db_connect("projects");
            $STH = $p->prepare("SELECT price FROM projects WHERE projects.id = :id");
            $data = array(
                'id' => $project_id
            );
            if ($STH->execute($data)) {
                $STH->setFetchMode(PDO::FETCH_ASSOC);
                $project = $STH->fetch();
                $p->beginTransaction();
                $STH = $p->prepare("UPDATE projects SET worker_id = :worker_id WHERE projects.id = :id");
                $data = array(
                    'worker_id' => $user_id,
                    'id' => $project_id
                );
                if ($STH->execute($data)) {
                    $u = db_connect("users");
                    $u->beginTransaction();
                    $STH = $u->prepare("UPDATE users SET
                money = money + (:money - (:money / 100 * 13))
                WHERE id = :user_id");;
                    $data = array(
                        'user_id' => $user_id,
                        'money' => $project['price']
                    );
                    $STH->execute($data);
                    $STH = $u->prepare("UPDATE users SET
                money = money + (:money / 100 * 13)
                WHERE role_id = 3");
                    $data = array(
                        'money' => $project['price']
                    );
                    $STH->execute($data);
                    if ($u->commit()) {
                        $p->commit();
                        $_SESSION['money'] += $project['price'];
                        setcookie('money', $_SESSION['money'], time() + 900);
                        echo $_SESSION['money'];
                    }
                }
            }
        }
}