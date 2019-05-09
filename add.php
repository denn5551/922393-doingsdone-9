<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');

session_start();

$user_id = $_SESSION['user']['id'];

$user_name = $_SESSION['user']['user_name'];

$projects = get_categories($con, $user_id);

$my_tasks = get_tasks($con, $user_id);

//$user_name = get_user_name ($con, $user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $required = ['name', 'date'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if (!empty($_FILES['file']['name'])) {
        $tmp_name = $_FILES['file']['tmp_name'];
        $path = $_FILES['file']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type !== 'image/jpeg') {
            $errors['file'] = 'Загрузите файл в формате jpeg';
        }
    }

    if (!empty($errors)) {
        $page_content = include_template('form-task.php', ['projects' => $projects, 'errors' => $errors]);

        $layout_content = include_template('layout.php', [
            'content' => $page_content,
            'my_tasks' => $my_tasks,
            'projects' => $projects,
            'show_complete_tasks' => $show_complete_tasks,
            'title' => 'Дела впорядке',
            'user_name' => $user_name,
        ]);

    } else {
        $filename = uniqid() . '.jpeg';
        $task['path'] = $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
        $sql = 'INSERT INTO task (projects_id, status, task_name, file, file_name, lifetime) VALUES (?, 0, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($con, $sql,
            [$_POST['project'], $_POST['name'], $task['path'], $path, $_POST['date']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: index.php");
        }
    }
} else {
    $page_content = include_template('form-task.php', ['projects' => $projects]);

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'my_tasks' => $my_tasks,
        'projects' => $projects,
        'show_complete_tasks' => $show_complete_tasks,
        'title' => 'Дела впорядке',
        'user_name' => $user_name,
    ]);

}

print($layout_content);


