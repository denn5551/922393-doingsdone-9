<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');

// TODO Сделать функции для всего что расположено ниже.

#Получаем id и названия категорий  для пользователя по id
$sql ="SELECT projects_name, id  FROM projects where user_id = $user_id;";
$result = mysqli_query($con, $sql);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);


# Получаем списко задач для всех категорий/проектов (если пользователь не выбрал конкретную категорию/проект)
$sql_task = "SELECT projects_id, task_name, status, lifetime  FROM task t
JOIN projects p
ON p.id = t.projects_id AND user_id = $user_id";
$result_task = mysqli_query($con,$sql_task);
$my_tasks = mysqli_fetch_all($result_task, MYSQLI_ASSOC);


# Получаем весь список категорий
$sql= "SELECT p.id, projects_name FROM projects p
JOIN task t
ON p.id = t.projects_id;";
$result= mysqli_query($con,$sql);
$count = mysqli_fetch_all($result, MYSQLI_ASSOC);


#Получаем имя пользователя
$sql_un = "SELECT user_name FROM users where id = $user_id;";
$result_un = mysqli_query($con,$sql_un);
$user_name = mysqli_fetch_assoc($result_un);


foreach ($projects as $project) {
# Проверяем что в GET задан пустой id ИЛИ В GET задано значение id которого несуществует
    if (isset($_GET['project']) && $_GET['project'] === '' || isset($_GET['project']) && $_GET['project'] !== $project['id']) {
        $page_content = include_template('404.php');
    }else {
        $page_content = include_template('index.php', ['my_tasks' => $my_tasks, 'show_complete_tasks' => $show_complete_tasks]);
        break;
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

