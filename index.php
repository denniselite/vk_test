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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Абстрактные заказы</title>
    <link href="./css/style.css" rel="StyleSheet" type="text/css">
    <meta charset="utf-8">
</head>
<body>
<?php if (!isset($_SESSION['id'])) { ?>
    <div class="login">
        Форма входа:
        <form method="POST" action="">
            <input type="text" name="login" placeholder="login"><br/>
            <input type="password" name="pass" placeholder="pass"><br/>
            <input type="submit" value="Войти">
        </form>
    </div>
<?php } else { ?>
    <div class="account">
        <p>Ваше имя : <?php echo $_SESSION['name']; ?></p>

        <p>Ваша роль : <span id="role"><?php echo $_SESSION['role']; ?></span></p>

        <p>Ваш баланс = <span id="money"><?php echo $_SESSION['money']; ?></span></p><br/>

        <input id="logout_button" type="button" value="Выйти">
    </div>
<?php } ?>
<div class="content">
    <?php if (isset($_SESSION['id'])&&($_SESSION['role_id'] == "1")) { ?>
    <div class="new_project">
        Создать новый проект:
        <form>
            <input id="desc" name="desc" type="text" placeholder="Описание проекта">
            <input id="price" name="price" type="text" placeholder="Цена">
            <input id="create_project" type="button" onclick="create_project(this.form)" value="Создать">
        </form>
    </div>
    <?php }?>
    <br/>

    <div class="projects">
        <div class="all_projects">
            Список проектов:
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
            Мои завершенные проекты:
            <table class="my_table">
                <tr>
                    <td>ID</td>
                    <td>Описание</td>
                    <td>Стартовая цена</td>
                </tr>
                <tbody id="my_projects">

                </tbody>
            </table>
        </div>
        <?php }?>
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
</html>