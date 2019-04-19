<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');



$page_content = include_template('index.php', ['my_tasks' => $my_tasks, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'my_tasks' => $my_tasks,
    'projects' => $projects,
    'show_complete_tasks' => $show_complete_tasks,
    'title' => 'Дела впорядке',
    'user_name' => 'Денис'
]);

print($layout_content);

