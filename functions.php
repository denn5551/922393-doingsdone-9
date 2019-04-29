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


