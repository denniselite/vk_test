<?php
session_start();
if ((!isset($_SESSION['id'])) && isset($_COOKIE['id']) && ($_COOKIE['id'] !== '')) {
    $_SESSION['id'] = $_COOKIE['id'];
    $_SESSION['name'] = $_COOKIE['name'];
    $_SESSION['money'] = $_COOKIE['money'];
    $_SESSION['role_id'] = $_COOKIE['role_id'];
    $_SESSION['role'] = $_COOKIE['role'];
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once "./functions/login.php";
    $user = login($_POST['login'], md5($_POST['pass']));
    if (!empty($user['login'])) {
        session_start();
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['money'] = $user['money'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['role'] = $user['role'];
        setcookie('id', $user['id'], time() + 900);
        setcookie('name', $user['name'], time() + 900);
        setcookie('role_id', $user['name'], time() + 900);
        setcookie('role', $user['role'], time() + 900);
        setcookie('money', $user['money'], time() + 900);
    }
}
$_SESSION['money'] = round($_SESSION['money'], 2);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Абстрактные заказы</title>
    <link href="./css/style.css" rel="StyleSheet" type="text/css">
    <meta charset="utf-8">
</head>
<body>
<header>
    <?php if (!isset($_SESSION['id'])) { ?>
        <table class="login">
            <tr>
                <td>Форма входа:</td>
                <form method="POST" action="">
                    <td><input type="text" name="login" placeholder="login"></td>
                    <td><input type="password" name="pass" placeholder="pass"></td>
                    <td><input class="login_button" type="submit" value="Войти"></td>
                </form>
            </tr>
        </table>
        </div>
    <?php } else { ?>
        <table class="account">
            <tr>
                <td>Привет, <?php echo $_SESSION['name']; ?>!</td>
                <td>Ваша роль : <span class="role" id="role"><?php echo $_SESSION['role']; ?></span></td>

                <td><?php if ($_SESSION['role_id'] == 3) {echo "Баланс системы";} else {echo "Ваш баланс";}?> = <span id="money"><?php echo $_SESSION['money']; ?></span></td>

                <td><input id="logout_button" type="button" class="logout_button" value="Выйти"></td>
            </tr>
        </table>
    <?php } ?>
</header>
<div class="content_wrapper">
    <div class="content">
        <div class="new_project" id="new_project"
             style="<?php if (isset($_SESSION['id']) && ($_SESSION['role_id'] == "1")) {
                 echo "display:block;";
             } else {
                 echo "display:none;";
             }?>">
            <div class="h">Создать новый проект:</div>
            <div class="new_projects_fields">
                <input class="desc" id="desc" name="desc" type="text" placeholder="Описание проекта">
            </div>
            <div class="new_projects_fields">
                <input class="price" id="price" name="price" type="text" placeholder="Цена">
            </div>
            <div class="new_projects_fields">
                <input  class="create_project_button" id="create_project" style="margin-top: -5px;" type="button" value="Создать">
            </div>
            <div id="project_status" class="project_status"></div>
        </div>

        <div class="projects">
            <div class="all_projects">
                <div class="name">Список проектов:</div>
                <table>
                    <tr>
                        <td>ID</td>
                        <td>Описание</td>
                        <td>Цена</td>
                        <td></td>
                    </tr>
                    <tbody id="projects_table">

                    </tbody>
                </table>
            </div>
            <?php if (isset($_SESSION['id'])) { ?>
                <div class="my_projects">
                    <div class="name">Мои завершенные проекты</div>
                    <table class="my_table">
                        <tr>
                            <td>ID</td>
                            <td>Описание</td>
                            <td>Цена</td>
                            <td>Роль</td>
                        </tr>
                        <tbody id="my_projects">

                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://jquery-json.googlecode.com/files/jquery.json-2.4.js"></script>
<script src="./js/get_projects.js"></script>
<script src="./js/logout.js"></script>
<script src="./js/new_project.js"></script>
<script src="./js/make_project.js"></script>
<script src="./js/change_role.js"></script>
<script>
    $("body").css({
        'height' : $(window).height()
    });
    $(".content_wrapper").css({
        'height' : $(window).height() - 100
    });
    $(".projects").css({
        'height' : $(window).height() - 100
    });
</script>
</html>