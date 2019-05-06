<?php
$con = mysqli_connect("localhost", "root", "","doingsdone");
mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: "
        . mysqli_connect_error());
};

$user_id = 10; // меняем id юзера для тестов (9 или 10)

// TODO Сделать функции для всего что расположено ниже.

#Получаем id и названия категорий  для пользователя по id
$sql ="SELECT projects_name, id  FROM projects where user_id = $user_id;";
$result = mysqli_query($con, $sql);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);


# Получаем списко задач для всех категорий/проектов (если пользователь не выбрал конкретную категорию/проект)
$sql_task = "SELECT projects_id, task_name, status, file, file_name, lifetime  FROM task t
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



