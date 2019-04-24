<?php
$con = mysqli_connect("localhost", "root", "","doingsdone");
mysqli_set_charset($con, "utf8");
if ($con == false) {
    print("Ошибка подключения: "
        . mysqli_connect_error());
}
else {
    print("Соединение установлено");
};

$user_id = 9; // меняем id юзера для тестов (9 или 10)

#Получаем категории для пользователя по id
$sql ="SELECT projects_name FROM projects where user_id = $user_id;";
$result = mysqli_query($con, $sql);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
// вывод срдержимого из полученного массива
//foreach ($project as $project) {
//    print("Категория: "
//        . $project['projects_name']);
//}

#Получаем список задач для пользователя по id
$sql_task = "SELECT projects_id, task_name,status,lifetime  FROM task t
JOIN projects p
ON p.id = t.projects_id AND user_id = $user_id";
$result_task = mysqli_query($con,$sql_task);
$my_tasks = mysqli_fetch_all($result_task, MYSQLI_ASSOC);

#Получаем количество задач для каждого проекта
$sql_count = "SELECT p.id, projects_name, COUNT(projects_name) FROM projects p
JOIN task t
ON  p.id = t.projects_id
GROUP BY projects_name;
";
$result_count = mysqli_query($con,$sql_count);
$count = mysqli_fetch_all($result_count, MYSQLI_ASSOC);

#Получаем имя пользователя
$sql_un = "SELECT user_name FROM users where id = $user_id;";
$result_un = mysqli_query($con,$sql_un);
$un = mysqli_fetch_assoc($result_un);
