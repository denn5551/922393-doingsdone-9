<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST;
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

    if (count($errors)) {
        $page_content = include_template('form-task.php',
            ['projects' => $projects, 'task' => $task, 'errors' => $errors]);
        $layout_content = include_template('layout.php', [
            'content' => $page_content,
            'my_tasks' => $my_tasks,
            'projects' => $projects,
            'show_complete_tasks' => $show_complete_tasks,
            'title' => 'Дела впорядке',
            'user_name' => $user_name,
        ]);

        print($layout_content);

    } else {
        $filename = uniqid() . '.jpeg';
        $task['path'] = $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
        $sql = 'INSERT INTO task (projects_id, data_task, status, task_name, file, lifetime) VALUES (?, NOW(), 0, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($con, $sql, [$task['project'], $task['name'], $task['path'], $task['date']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: index.php");
        }
    }
} else {
    header("Location: index.php?page=form-task");
}




