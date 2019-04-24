<?php
//function count_projects($task_list, $project_name)
//{
//    $i = 0;
//    foreach ($task_list as $task) {
//
//        if ($task["category"] === $project_name) {
//            $i++;
//        }
//    }
//    return $i;
//}

function user_date($user_date)
{
    $date_naw = strtotime(date('d M Y '));

    $user_date_midnight = strtotime("+23 hours", strtotime($user_date));

    $hours_left = floor(($user_date_midnight - $date_naw) / 3600);

    return $hours_left;
}

function count_projects($task_list, $project_name)
{
    $count_task = 0;
    foreach ($project_name as $project) {

        if ($task_list["projects_name"] === $project['projects_name']) {
            $count_task = $project['COUNT(projects_name)'];

        }
    }
    return $count_task;
}

function user_important($time_important)
{
    if (user_date($time_important) <= 24 && user_date($time_important) >= 0) {
        $important = 'task--important';
    } else {
        $important = '';
    }
    return $important;
}

function task_status($status)
{
    foreach ($status as $stat){
    if($stat['status']){
        $status = 'checked';
    }else
        {
        $status = '';
    }
}
    return $status;
}
