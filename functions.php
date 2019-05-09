<?php
/**
 * Определяет сколько часов осталось до закрытия задачи
 * @param data $user_date — дата завершения задания
 */
function hours_left_to_close_task($user_date)
{
    $date_now = strtotime(date('d M Y '));

    $user_date_midnight = strtotime("+23 hours", strtotime($user_date));

    $hours_left = floor(($user_date_midnight - $date_now) / 3600);

    return $hours_left;
}

/**
 *Считает количество задач в конкретном проекте
 * @param Array $task_list — список всех задач пользоветля
 * @param Array $category — текущая категория(проекта) пользователя
 * @return int
 */

function count_tasks_in_project($category, $task_list)
{
    $i = 0;
    foreach ($task_list as $task) {
        if ($category['id'] === $task['projects_id']) {
            $i++;
        }
    }
    return $i;
}

/**
 * Проверят время до выполнения задачи больше 0 и меньше 24
 * @param data $time_to_close_task — Время завершения задачи
 */
function is_task_important($time_to_close_task)
{
    if (hours_left_to_close_task($time_to_close_task) <= 24 && hours_left_to_close_task($time_to_close_task) >= 0) {
        return true;
    }
    return false;
}

/**
 * Поулчаем асоциативный массив из данных БД для всех строк выборки
 * $con - подключение к БД
 * $sql - запрос к БД
 */
function fetch_all ($con, $sql)
{
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Поулчаем асоциативный массив из данных БД для одной строки выборки
 * $con - подключение к БД
 * $sql - запрос к БД
 */
function fetch_one ($con, $sql)
{
    $result = mysqli_query($con,$sql);
    return mysqli_fetch_assoc($result);
}

/**
 * Получаем id и названия категорий  для пользователя по id
 * $con - подключение к БД
 * $user_id - id пользователя
 */
function get_categories ($con, $user_id)
{
    $sql ="SELECT projects_name, id  FROM projects where user_id = '$user_id';";
    return fetch_all ($con, $sql);
}

/**
 * Получаем списко задач для всех категорий/проектов (если пользователь не выбрал конкретную категорию/проект)
 * $con - подключение к БД
 * $user_id - id пользователя
 */
function get_tasks ($con, $user_id)
{
    $sql = "SELECT projects_id, task_name, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id AND user_id = '$user_id'";
    return fetch_all ($con, $sql);
}

/**
 * Получаем имя пользователя
 * $con - подключение к БД
 * $user_id - id пользователя
 */
//function get_user_name ($con, $user_id)
//{
//    $sql = "SELECT user_name FROM users where id = $user_id;";
//    return fetch_one ($con, $sql);
//}