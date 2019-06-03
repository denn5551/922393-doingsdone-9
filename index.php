<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');


if ($is_auth) {

    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    $page_content = include_template('index.php');

    $show_complete_tasks = 0;

    foreach ($projects as $project) {
        if (isset($_GET['project'])) {
            if (((integer)$_GET['project']) === $project['id']) {
                # Фильтры по задачам для конкретного проекта
                $all_get_filters = ['all','today','tomorrow', 'overdue'];
                foreach ($all_get_filters as $get){
                    if ($_GET['project'] && (isset($_GET[$get]))) {
                        $my_tasks_completed = get_lifetime ($con, $user_id, isset($_GET[$get]), $project['id']);
                        $page_content = include_template('index.php',
                            ['my_tasks' => $my_tasks_completed, 'show_complete_tasks' => $show_complete_tasks]);
                        break 2;
                    }
                }
            } else {
                $page_content = include_template('404.php');
            }
        } else {
                $my_tasks_all_tasks = get_tasks($con, $user_id, 0, false);
                $page_content = include_template('index.php',
                    ['my_tasks' => $my_tasks_all_tasks, 'show_complete_tasks' => $show_complete_tasks]);
        }
    }

# Чекбокс "Показать выполненные"
    if (!empty($_GET['show_completed']) && isset($_GET['project']) === false){
        $my_tasks_completed = get_tasks($con, $user_id, false, false);
        $show_complete_tasks = 1;
        $page_content = include_template('index.php',
            ['my_tasks' => $my_tasks_completed, 'show_complete_tasks' => $show_complete_tasks]);

    }

# Фильтры для всех задач на главной
    if (isset($_GET['all']) || isset($_GET['today']) || isset($_GET['tomorrow']) || isset($_GET['overdue'])){
        $all_get_filters = ['all','today','tomorrow', 'overdue'];
        foreach ($all_get_filters as $get){
            if (isset($_GET[$get]) && empty($_GET['project'])) {
                $my_tasks_completed = get_lifetime ($con, $user_id, isset($_GET[$get]), false );
                $page_content = include_template('index.php',
                    ['my_tasks' => $my_tasks_completed, 'show_complete_tasks' => $show_complete_tasks]);
                break;
            }
        }
    }

# Пометить задачу как выполненую
    if(isset($_GET['check'])){
        $id_task = $_GET['task_id'];
        $sql = "update task set status = case when status = 1 then 0 else 1 end
                WHERE id = ?";
        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$id_task]);
        $res = mysqli_stmt_execute($stmt);
        header("Location: index.php");
    }

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'my_tasks' => $my_tasks,
        'projects' => $projects,
        'title' => 'Дела впорядке',
        'user_name' => $user_name,
        'is_auth' => $is_auth,
    ]);

} else {
    $page_content = include_template('guest.php');
    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Главная',
    ]);
}
print($layout_content);