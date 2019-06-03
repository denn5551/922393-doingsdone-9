<?php
require_once('helpers.php');
require_once('init.php');
require_once('functions.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $required = ['name', 'password'];
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
    } elseif (!empty($_POST['email']) === false) {
        $errors['email'] = 'Это поле надо заполнить';
    } else {
        $errors['email'] = 'Введите правильный email';
    }

    if (!empty($errors)) {
        $page_content = include_template('register.php', ['errors' => $errors]);
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (email, user_name, password) VALUES (?, ?, ?)';
        $stmt = db_get_prepare_stmt($con, $sql, [$_POST['email'], $_POST['name'], $password]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header("Location: index.php");
        }
    }
} else {
    $page_content = include_template('register.php');
}
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Регистрация аккаунта',
]);

print($layout_content);


