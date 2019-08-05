<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

if ($is_auth) {
    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $user_email = $_SESSION['user']['email'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    $page_content = include_template('history.php');
}else {
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
    'title' => 'История версий',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
]);
print($layout_content);
