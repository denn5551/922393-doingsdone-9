<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/init.php');


if ($is_auth) {
    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    # Получаем данные пользователя
    $sql = 'SELECT date_reg, user_name, email,update_session FROM users where id = ?;';

    $stmt = db_get_prepare_stmt($con, $sql, [$user_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $users_data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $page_content = include_template('user.php', ['users_data' => $users_data]);

    if (isset($_POST["user_data"])){
        $page_content = include_template('user_edit.php',['users_data' => $users_data]);
    }

    #Обновляем сессию при смене имени
    foreach ($users_data as $users){

        if (isset($users["update_session"]) && (int)$users["update_session"] === 1) {
            $_SESSION['user']['user_name'] = $users["user_name"];
        }

        $sql = 'UPDATE users SET update_session = 0 WHERE id = ?';
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id]);
        $res = mysqli_stmt_execute($stmt);
    }

    if (isset($_POST["user_edit"])){
        $required = ['name'];
        $errors = [];
        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите правильный email';
        } elseif (!empty($_POST['email']) === false) {
            $errors['email'] = 'Это поле надо заполнить';
        }

        if (!empty($errors)) {
            $page_content = include_template('user_edit.php', [
                'projects' => $projects,
                'errors' => $errors,
                'users_data' => $users_data,
            ]);
        } else {
            $sql = "UPDATE users SET user_name =  ?, email = ?, update_session = 1 WHERE id = ?";
            $stmt = db_get_prepare_stmt($con, $sql, [$_POST['name'], $_POST['email'], $user_id]);
            $res = mysqli_stmt_execute($stmt);
            if ($res){
                header("Location: /controller/user.php?success=true");
            }
        }

    }

} else {
    $page_content = include_template('guest.php');
    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Главная',
    ]);
    print($layout_content);
    exit();
}
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'my_tasks' => $my_tasks,
    'projects' => $projects,
    'title' => 'Личный кабинет',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
]);
print($layout_content);
