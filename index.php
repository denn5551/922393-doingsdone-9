<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');


// TODO Сделать функции для всего что расположено ниже.

id_category ($con,$user_id);

task_list_categories ($con, $user_id);

user_name ($con, $user_id);

//foreach ($projects as $project) {
//# Проверяем что в GET задан пустой id ИЛИ В GET задано значение id которого несуществует
//    if (isset($_GET['project']) && $_GET['project'] === '' || isset($_GET['project']) && $_GET['project'] !== $project['id']) {
//        $page_content = include_template('404.php');
//    }else {
//        $page_content = include_template('index.php', ['my_tasks' => $my_tasks, 'show_complete_tasks' => $show_complete_tasks]);
//        break;
//    }
//}

foreach ($projects as $project) {
    # проверяем что параметр get существует и равен id проекта. Если нет показываем стр. 404
    if (!empty($_GET['project']) && ($_GET['project'] === $project['id'])) {
        $page_content = include_template('index.php',
            ['my_tasks' => $my_tasks, 'show_complete_tasks' => $show_complete_tasks]);
        break;
    } elseif (boolval(isset($_GET['project'])) === false) { // если равно false значит запроса get не было и надо показать все задачи
        $page_content = include_template('index.php',
            ['my_tasks' => $my_tasks, 'show_complete_tasks' => $show_complete_tasks]);
    } elseif (boolval(isset($_GET['project'])) === true) { // если равно true значит в запросе get не уазан параметр и нужно показать стр. 404
        $page_content = include_template('404.php');
    } else {
        $page_content = include_template('404.php');
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'my_tasks' => $my_tasks,
    'projects' => $projects,
    'show_complete_tasks' => $show_complete_tasks,
    'title' => 'Дела впорядке',
    'user_name' => $user_name,
]);

print($layout_content);

