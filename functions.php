<?php
/**
* Определяет сколько часов осталось до закрытия задачи
* @param data $user_date — дата завершения задания
 */
function user_date($user_date)
{
    $date_now = strtotime(date('d M Y '));

    $user_date_midnight = strtotime("+23 hours", strtotime($user_date));

    $hours_left = floor(($user_date_midnight - $date_now) / 3600);

    return $hours_left;
}

/**
 *Считает количество задач в конкретном проекте
 * @param String  $task_list — список категорий пользователя
 * @param Array $all_categories — список всех категорий с задачами
 * @return int|mixed
 */

function count_tasks_in_project($task_list, $all_categories)
{
    $i = 0;
    foreach ($all_categories as $category) {
        if ($task_list["projects_name"] === $category['projects_name']) {
            $i++;
        }
    }
    return $i;
}

/**
* Проверят время до выполнения задачи больше 0 и меньше 24
* @param data $time_important — Время завершения задачи
 */
function task_important($time_important)
{
    if (user_date($time_important) <= 24 && user_date($time_important) >= 0) {
        $important = true;
    } else {
        $important = false;
    }
    return $important;
}


