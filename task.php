<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');


if ($is_auth) {
    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    $errors = [];

# Переходим на стр редактирования и получаем данные по задаче
    if (isset($_GET['task-edit'])){
        $sql = 'SELECT t.id, projects_id, task_name, task_description, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? AND t.id = ?';

        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id, $_GET['task-edit']]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $my_tasks_edit = mysqli_fetch_all($res, MYSQLI_ASSOC);

        $page_content = include_template('task-edit.php', [
            'my_tasks' => $my_tasks_edit,
            'projects' => $projects,
        ]);
    }
# Проверяем существует ли файл и правильного ли он формата
    if (!empty($_FILES['file']['name'])) {
        $tmp_name = $_FILES['file']['tmp_name'];
        $path = $_FILES['file']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        $filename = uniqid() . '.jpeg';

        if ($file_type !== 'image/jpeg') {
            $errors['file'] = 'Загрузите файл в формате jpeg';
        }
    }

# проверяем что бы дата была больше или равна текущей
    if (!empty($_POST['date'])){
        $time_post = strtotime($_POST['date']);
        $time_now = strtotime(date('Y-m-d'));
        if ($time_post < $time_now) {
            $errors['date'] = 'Укажите правильную дату';
        }
    } else {
        $_POST['date'] = 0;
    }

# Проверяем на ошибки
    if (!empty($errors)) {
        $my_tasks_edit = [[projects_id => $_POST['project'], task_name => $_POST['name'], task_description => $_POST['textarea'], lifetime => $_POST['date'], id =>$_POST['id']]];
        $page_content = include_template('task-edit.php', ['projects' => $projects, 'my_tasks' => $my_tasks_edit, 'errors' => $errors]);
    } elseif (isset($_POST['edit'])) { // Отправляем запрос на изменение задачи
        $task['path'] = $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
        $sql = "UPDATE task SET projects_id = ?, task_name = ?, task_description = ?, file = ?, file_name = ?, lifetime = ? WHERE id = ?";
        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$_POST['project'], $_POST['name'], $_POST['textarea'], $task['path'], $path, $_POST['date'], $_POST['id']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res){
            header("Location: index.php?success-task=true");
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
