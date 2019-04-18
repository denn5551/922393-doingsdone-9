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