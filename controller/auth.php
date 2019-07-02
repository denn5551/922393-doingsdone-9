<?php
require_once('../helpers.php');
require_once('../init.php');
require_once('../functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['password'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($con, $sql);

        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

        if (!$user) {
            $errors['email'] = 'Такой пользователь не найден';
        }

        if (!count($errors) && $user) {
            if (password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user'] = $user;
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        }

    } elseif (!empty($_POST['email']) === false) {
        $errors['email'] = 'Это поле надо заполнить';
    } else {
        $errors['email'] = 'Введите корректный email';
    }

    if (!empty($errors)) {
        $page_content = include_template('authorization.php', ['errors' => $errors]);
    } else {
        header("Location: /index.php");
    }

} else {
    $page_content = include_template('authorization.php');
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Вход на сайт',
]);

print($layout_content);