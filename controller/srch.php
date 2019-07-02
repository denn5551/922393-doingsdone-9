<?php
require_once('../helpers.php');
require_once('../functions.php');
require_once('../init.php');

if ($is_auth) {

    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);


    $search = $_GET['search'] ?? '';
    if ($search) {
        $sql = "SELECT t.id, projects_id, task_name, status, file, file_name, lifetime  FROM task t
                JOIN projects p
                ON p.id = t.projects_id  WHERE user_id = $user_id
                AND MATCH(task_name) AGAINST(?) ";

        $stmt = db_get_prepare_stmt($con, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $my_tasks_search = mysqli_fetch_all($res, MYSQLI_ASSOC);

        $page_content = include_template('index.php', ['my_tasks' => $my_tasks_search]);

    } else {
        $page_content = include_template('index.php', ['my_tasks' => $my_tasks]);
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
