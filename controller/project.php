<?php
require_once('../helpers.php');
require_once('../functions.php');
require_once('../init.php');

if ($is_auth) {

    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    if (isset($_POST['save-prodj'])){

        $errors = [];
        # проверяем что бы название проекта было не пусто
        if (empty($_POST['name'])) {
            $errors['name'] = 'Введите название проекта';
        }

        # проверяем что бы название проекта не повторялось
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $sql = "SELECT id FROM projects WHERE projects_name = '$name'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['name'] = 'Проект с таким названием уже существует.';
        }
        # проверяем есть ли ошибки
        if (!empty($errors)) {
            $projects_err = one_projects ($con, $_POST['id']);

            $page_content = include_template('project.php', ['projects' => $projects_err, 'errors' => $errors]);
        } else {// если ошибок нет обновляем название проекта
            $sql = "UPDATE projects SET projects_name = ? WHERE id = ?";
            mysqli_prepare($con, $sql);
            $stmt = db_get_prepare_stmt($con, $sql, [$_POST['name'], $_POST['id']]);
            $res = mysqli_stmt_execute($stmt);
            if ($res){
                header("Location: /controller/project.php?id=" . $_POST['id'] . "&success=true");
            }
        }

    } else {
        $projects_edit = one_projects ($con, $_GET['id']);;

        $page_content = include_template('project.php', ['projects' => $projects_edit]);
    }

    if (isset($_POST['back'])) {
        header("Location: /index.php?project=" . $_POST['id'] . "&all");
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
    'title' => 'Редактирование проекта',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
]);

print($layout_content);
