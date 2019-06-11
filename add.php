<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

if ($is_auth) {

    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    $page_content = include_template('index.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $required = ['name'];
        var_dump($required);
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
            $filename = uniqid() . '.jpeg';

            if ($file_type !== 'image/jpeg') {
                $errors['file'] = 'Загрузите файл в формате jpeg';
            }
        }
        // проверяем что бы дата была больше или равна текущей

        if (!empty($_POST['date'])){
            $time_post = strtotime($_POST['date']);
            $time_now = strtotime(date('Y-m-d'));
            if ($time_post < $time_now) {
                $errors['date'] = 'Укажите правильную дату';
            }
        } else {
            $_POST['date'] = 0;
        }
        // проверяем есть ли ошибки
        if (!empty($errors)) {
            $page_content = include_template('form-task.php', ['projects' => $projects, 'errors' => $errors]);
        } else {
            $task['path'] = $filename;
            move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
            $sql = 'INSERT INTO task (projects_id, data_task, status, task_name, task_description, file, file_name, lifetime) VALUES (?, NOW(), 0, ?, ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql,
                [$_POST['project'], $_POST['name'], $_POST['textarea'], $task['path'], $path, $_POST['date']]);
            $res = mysqli_stmt_execute($stmt);
            if ($res && isset($_POST["button2"])) {
                header("Location: add.php?success=true");
            } elseif ($res) {
                header("Location: index.php?success=true");
            }
        }
    } else {
        $page_content = include_template('form-task.php', ['projects' => $projects]);
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
    'title' => 'Добавление задачи',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
]);
print($layout_content);


