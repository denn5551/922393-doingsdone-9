<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/init.php');

if ($is_auth) {

    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        foreach ($projects as $project) {
            if (trim($_POST['name']) === $project['projects_name']) {
                $errors['name'] = 'Такое название проекта уже существует';
            }
        }
        if (!empty($_POST['name']) === false) {
            $errors['name'] = 'Напишите название проекта';
        }

        if (!empty($errors)) {
            $page_content = include_template('form-project.php', ['errors' => $errors]);

        } else {
            $sql = 'INSERT INTO projects (user_id, projects_name) VALUES (?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql, [$user_id, $_POST['name']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                header("Location: /index/success_project");
            }
        }
    } else {
        $page_content = include_template('form-project.php');
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
    'title' => 'Дела впорядке',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
]);
print($layout_content);