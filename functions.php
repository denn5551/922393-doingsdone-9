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
        if ($category['id'] == $task['projects_id']) {
            $i++;
        }
    }
    return $i;
}

/**
 * Проверят время до выполнения задачи больше 0 и меньше 24, меньше
 * @param data $time_to_close_task — Время завершения задачи
 * return true - больше 0 и меньше 24
 * return false - меньше 0
 * return 1 - больше 24 и меньше 48
 */
function is_task_important($time_to_close_task)
{
    if (hours_left_to_close_task($time_to_close_task) <= 24 && hours_left_to_close_task($time_to_close_task) >= 0) {
        return true;
    } elseif (hours_left_to_close_task($time_to_close_task) < 0) {
        return false;
    } elseif (hours_left_to_close_task($time_to_close_task) > 24 && hours_left_to_close_task($time_to_close_task) <= 48) {
        return 1;
    }

}

/**
 * Поулчаем асоциативный массив из данных БД для всех строк выборки
 * $con - подключение к БД
 * $sql - запрос к БД
 */
//function fetch_all ($con, $sql)
//{
//    $result = mysqli_query($con, $sql);
//    return mysqli_fetch_all($result, MYSQLI_ASSOC);
//}

/**
 * Поулчаем асоциативный массив из данных БД для одной строки выборки
 * $con - подключение к БД
 * $sql - запрос к БД
 */
//function fetch_one ($con, $sql)
//{
//    $result = mysqli_query($con,$sql);
//    return mysqli_fetch_assoc($result);
//}

/**
 * Получаем id и названия категорий  для пользователя по id
 * $con - подключение к БД
 * $user_id - id пользователя
 */
function get_categories ($con, $user_id)
{
    $sql ="SELECT projects_name, id  FROM projects where user_id = ?;";
    mysqli_prepare($con, $sql);
    $stmt = db_get_prepare_stmt($con, $sql, [$user_id]);

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);

//    return fetch_all ($con, $sql);
}


/**
 * @param $con
 * @param $user_id
 * @param $projects_id
 * @param $status
 * @return array|null
 */

function get_tasks ($con, $user_id, $status, $projects_id)
{
    if (!empty($projects_id)) {
        $sql = "SELECT t.id, projects_id, task_name, status, file, file_name, lifetime  FROM task t
   JOIN projects p
   ON p.id = t.projects_id  WHERE user_id = ? AND projects_id = ? ";

        if ($status === 0){
            $sql .= 'AND status = 0 ';
        } elseif ($status === 1) {
            $sql .= 'AND status = 1 ';
        } elseif ($status == false) {
            $sql .= '';
        }
        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id, $projects_id]);
    } else {
        $sql = "SELECT t.id, projects_id, task_name, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? ";

        if ($status === 0){
            $sql .= 'AND status = 0 ';
        } elseif ($status === 1) {
            $sql .= 'AND status = 1 ';
        } elseif ($status == false) {
            $sql .= '';
        }
        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id]);
    }

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

/**
 * Получаем задачи с определенным статусом статусом
 * @param $con
 * @param $user_id
 * @param $status
 * @return array|null
 */
//function get_tasks ($con, $user_id, $status)
//{
//
//    $sql = "SELECT t.id, projects_id, task_name, status, file, file_name, lifetime  FROM task t
//    JOIN projects p
//    ON p.id = t.projects_id  WHERE user_id = ? ";
//
//    if ($status === 0){
//        $sql .= 'AND status = 0 ';
//    } elseif ($status === 1) {
//        $sql .= 'AND status = 1 ';
//    } elseif ($status == false) {
//        $sql .= '';
//    }
//    mysqli_prepare($con, $sql);
//    $stmt = db_get_prepare_stmt($con, $sql, [$user_id]);
//
//    mysqli_stmt_execute($stmt);
//    $res = mysqli_stmt_get_result($stmt);
//    return mysqli_fetch_all($res, MYSQLI_ASSOC);
//}

/**
 * Получаем все задачи для конкретного проекта (не нужна)
 * @param $con
 * @param $user_id
 * @param $projects_id
 * @return array|null
 */
//function get_tasks_projects ($con, $user_id, $projects_id)
//{
//    $sql = "SELECT t.id, projects_id, task_name, status, file, file_name, lifetime  FROM task t
//   JOIN projects p
//   ON p.id = t.projects_id  WHERE user_id = ? AND projects_id = ?";
//    mysqli_prepare($con, $sql);
//    $stmt = db_get_prepare_stmt($con, $sql, [$user_id, $projects_id]);
//    mysqli_stmt_execute($stmt);
//    $res = mysqli_stmt_get_result($stmt);
//    return mysqli_fetch_all($res, MYSQLI_ASSOC);
//}


/**
 * @param $con
 * @param $user_id
 * @param $get
 * @param $projects_id
 * @return array|null
 */
function get_lifetime ($con, $user_id, $get, $projects_id){
    if (!empty($projects_id)) {
        $sql = 'SELECT t.id, projects_id, task_name, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? AND projects_id = ?  ' ;

        if ($get === isset($_GET['today'])){
            $sql.= 'AND lifetime = CURRENT_DATE AND status = 0';
        } elseif ($get === isset($_GET['tomorrow'])){
            $sql.= 'AND lifetime = CURRENT_DATE + 1 AND status = 0';
        }  elseif ($get === isset($_GET['overdue'])){
            $sql.= 'AND lifetime < CURRENT_DATE AND status = 0';
        }elseif ($get == isset($_GET['all'])){
            $sql.= 'AND lifetime = lifetime AND status = 0';
        }

        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id,  $projects_id]);
    } else {
        $sql = 'SELECT t.id, projects_id, task_name, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? ' ;

        if ($get === isset($_GET['today'])){
            $sql.= 'AND lifetime = CURRENT_DATE AND status = 0';
        } elseif ($get === isset($_GET['tomorrow'])){
            $sql.= 'AND lifetime = CURRENT_DATE + 1 AND status = 0';
        } elseif ($get === isset($_GET['overdue'])){
            $sql.= 'AND lifetime < CURRENT_DATE AND status = 0';
        }elseif ($get === isset($_GET['all'])){
            $sql.= 'AND lifetime = lifetime AND status = 0';
        }
        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id]);
    }

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}
