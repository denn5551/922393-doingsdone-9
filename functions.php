<?php
function count_projects($task_list, $project_name)
{
    $i = 0;
    foreach ($task_list as $task) {

        if ($task["category"] === $project_name) {
            $i++;
        }
    }
    return $i;
}

function user_date($user_date)
{
    $date_naw = strtotime(date('d M Y '));

    $user_date_midnight = strtotime( "+23 hours",strtotime($user_date));

    $hours_left = floor(($user_date_midnight - $date_naw)/3600);

    return $hours_left;
}

