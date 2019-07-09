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
 * @param $time_to_close_task — Время завершения задачи
 * return true - больше 0 и меньше 24
 */
function is_task_important($time_to_close_task)
{
    if (hours_left_to_close_task($time_to_close_task) <= 24 && hours_left_to_close_task($time_to_close_task) >= 0) {
        return true;
    }
}

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
}

/**
 * Добавляем статус задачи в sql запрос
 * @param $status - статус
 * @return string
 */
function status_task($status)
{
    if ($status === 0){
        return 'AND status = 0 ';
    }
        return 'AND status = 1 ';

}

/**
 * Добавляем выбор по времене в sql запрос
 * @param $get - GET запрос
 * @return string
 */
function lifetime_task ($get)
{
    if ($get === isset($_GET['today'])){
        return 'AND lifetime = CURRENT_DATE AND status = 0';
    } elseif ($get === isset($_GET['tomorrow'])){
        return 'AND lifetime = CURRENT_DATE + 1 AND status = 0';
    } elseif ($get === isset($_GET['overdue'])){
        return 'AND lifetime < CURRENT_DATE AND lifetime > 0 AND status = 0';
    } elseif ($get === isset($_GET['notime'])){
        return 'AND lifetime = 0 AND status = 0';
    }
        return 'AND lifetime = lifetime AND status = 0';

}
/**
 * Получаем задачи в зависимости от статуса и id проектеа
 * @param $con - подключение к бд
 * @param $user_id - id юзера
 * @param $projects_id - id проекта
 * @param $status - нужный статус проекта
 * @return array|null
 */
function get_tasks ($con, $user_id, $status, $projects_id)
{
    if (!empty($projects_id)) {
        $sql = "SELECT t.id, projects_id, task_name, task_description, status, file, file_name, lifetime  FROM task t
   JOIN projects p
   ON p.id = t.projects_id  WHERE user_id = ? AND projects_id = ? ";

        $sql .= status_task($status);

        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id, $projects_id]);
    } else {
        $sql = "SELECT t.id, projects_id, task_name, task_description, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? ";

        $sql .= status_task($status);

        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id]);
    }

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

/**
 * Получаем задачи по времени в зависимости от выбранного фильтра
 * @param $con - подключение к бд
 * @param $user_id - id юзера
 * @param $get - get запрос из фильтров
 * @param $projects_id - id проекта
 * @return array|null
 */
function get_lifetime ($con, $user_id, $get, $projects_id){
    if (!empty($projects_id)) {
        $sql = 'SELECT t.id, projects_id, task_name, task_description, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? AND projects_id = ?  ' ;

        $sql .= lifetime_task($get);

        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id,  $projects_id]);
    } else {
        $sql = 'SELECT t.id, projects_id, task_name, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? ' ;

        $sql .= lifetime_task($get);

        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$user_id]);
    }

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

/**
 * Получаем данные по одной задаче по id
 * @param $con - подключение
 * @param $user_id - id .pthf
 * @param $id - id задачи
 * @return array|null - данные по одной задаче
 */
function one_task ($con, $user_id, $id) {
    $sql = 'SELECT t.id, projects_id, task_name, task_description, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? AND t.id = ?';

    mysqli_prepare($con, $sql);
    $stmt = db_get_prepare_stmt($con, $sql, [$user_id, $id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

/**
 * Получаем данные по одному проекту
 * @param $con - подключение
 * @param $id - id проекта из post или get запроса
 * @return array|null
 */
function one_projects ($con, $id) {
    $sql = "SELECT id,projects_name FROM projects WHERE id =?";
    $stmt = db_get_prepare_stmt($con, $sql, [$id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

/**
 * Добавляем в запрос sql id категории для постраничного вывода. Также проверяем что бы
 * get запрос был чилом (защита от sql иньекций).
 * @param $get - гет запрос
 */
function pagination_project ($get) {
    if ($get > 0 && is_numeric($get)){
        return ' AND projects_id = ' . $get . ' ';
    }
        return '';
}

/**
 * Постраничный вывод задач
 * @param $con - подключение
 * @param $status - статус задачи
 * @param $user_id - id юзера
 * @return array my_tasks_pag, pages, pages_count, cur_page
 */
function pagination ($con, $status, $user_id, $get) {
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 5;

    $sql = 'SELECT COUNT(*) as projects_id  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? ';
    $sql .= pagination_project ($get);
    $sql .= status_task($status);

    $stmt = db_get_prepare_stmt($con, $sql, [$user_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    $items_count = mysqli_fetch_assoc($res)['projects_id'];

    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;

    $pages = range(1, $pages_count);

    // запрос на показ задач
    $sql = 'SELECT t.id, projects_id, task_name, task_description, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = ? ';
    $sql .= pagination_project ($get);
    $sql .= status_task($status);
    $sql .= '  LIMIT ? OFFSET ? ';

    mysqli_prepare($con, $sql);
    $stmt = db_get_prepare_stmt($con, $sql, [$user_id, $page_items, $offset]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    return ['my_tasks_pag' => mysqli_fetch_all($res, MYSQLI_ASSOC), 'pages' => $pages, 'pages_count' => $pages_count, 'cur_page' => $cur_page];

}