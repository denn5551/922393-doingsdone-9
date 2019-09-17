<?php
require_once('../helpers.php');
require_once('../functions.php');
require_once('../init.php');

if ($is_auth) {

    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    if (isset($_POST['save-prodj'])){

        $errors = [];
        # проверяем что бы название проекта было не пусто
        if (empty($_POST['name'])) {
            $errors['name'] = 'Введите название проекта';
        }

        # проверяем что бы название проекта не повторялось
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $sql = "SELECT id FROM projects WHERE projects_name = '$name'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['name'] = 'Проект с таким названием уже существует.';
        }

        # проверяем есть ли ошибки
        if (!empty($errors)) {
            $projects_err = one_projects($con, $_POST['id']);

            $page_content = include_template('project.php', ['projects' => $projects_err, 'errors' => $errors]);
        } else {
            # если ошибок нет обновляем название проекта
            $sql = "UPDATE projects SET projects_name = ? WHERE id = ?";
            $stmt = db_get_prepare_stmt($con, $sql, [$_POST['name'], $_POST['id']]);
            $res = mysqli_stmt_execute($stmt);
            if ($res) {
                header("Location: /project/id/" . $_POST['id'] . "/success");
            }
        }
    }

    # Удаляем проект, задачи и файлы.
    if (isset($_POST['del-prodj'])) {
        # Удаляем файлы из задач
        $sql = "SELECT id FROM task WHERE projects_id = ?";
        $stmt = db_get_prepare_stmt($con, $sql, [$_POST['id']]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $id_proj = mysqli_fetch_all($res, MYSQLI_ASSOC);

       foreach ($id_proj as $id) {

           foreach ($id as $file_name) {

               $sql = "SELECT file FROM task WHERE id = " . $file_name;
               $stmt = db_get_prepare_stmt($con, $sql);
               mysqli_stmt_execute($stmt);
               $res = mysqli_stmt_get_result($stmt);
               $task_file_name = mysqli_fetch_array($res, MYSQLI_ASSOC);
               foreach ($task_file_name as $id_file) {
                   if (!empty($id_file)) {
                       unlink($_SERVER['DOCUMENT_ROOT'] . 'uploads/' . $id_file);
                   }
               }
           }
       }

        # удаляем задачи
        $sql = "DELETE FROM task
        WHERE projects_id = ?";
        $stmt = db_get_prepare_stmt($con, $sql, [$_POST['id']]);
        $res = mysqli_stmt_execute($stmt);

        # удаляем проект
        $sql = "DELETE FROM projects
        WHERE id = ?";;
        $stmt = db_get_prepare_stmt($con, $sql, [$_POST['id']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res){
            header("Location: /index/success_del_proj");
        }
    }

    if (isset($_POST['back'])) {
        header("Location: /project/" . $_POST['id'] . "/page/1/all");
    }

    $projects_edit = one_projects ($con, $_GET['id']);;

    $page_content = include_template('project.php', ['projects' => $projects_edit]);


} else {
    $page_content = include_template('guest.php');

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Главная',
    ]);
    print($layout_content);
    exit();
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'my_tasks' => $my_tasks,
    'projects' => $projects,
    'title' => 'Редактирование проекта',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
]);

print($layout_content);
