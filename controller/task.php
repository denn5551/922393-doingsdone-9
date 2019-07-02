<?php
require_once('../helpers.php');
require_once('../functions.php');
require_once('../init.php');


if ($is_auth) {
    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    $errors = [];

# Переходим на стр редактирования и получаем данные по задаче
    if (isset($_GET['task-edit'])){

        $my_tasks_edit = one_task ($con, $user_id, $_GET['task-edit']);

        $page_content = include_template('task-edit.php', [
            'my_tasks' => $my_tasks_edit,
            'projects' => $projects,
        ]);
    }

    # Удаляем файл из задачи при редактировании проекта
    if (isset($_GET['delete-file'])) {

        unlink ('../uploads/' . $_GET['delete-file']);

        $sql = "UPDATE task SET FILE = '', file_name = '' WHERE id = ?";
        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$_GET['id']]);
        $res = mysqli_stmt_execute($stmt);

        $my_tasks_edit = one_task ($con, $user_id, $_GET['id']);

        $page_content = include_template('task-edit.php', [
            'my_tasks' => $my_tasks_edit,
            'projects' => $projects,
        ]);
    }

# Проверяем не привышает ли описание проекта заданное значение 150 символов.
    if (isset($_POST['textarea']) && (iconv_strlen($_POST['textarea']) > 155)) {
        $errors['textarea'] = 'Привышен лимит в 155 символов. Удалите лишний текст.';
    }

# Проверяем существует ли файл и правильного ли он формата
    if (!empty($_FILES['file']['name'])) {
        $tmp_name = $_FILES['file']['tmp_name'];
        $path = $_FILES['file']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        $filename = uniqid() . '.jpeg';

//        unlink ('uploads/' . $_POST['file_name']);

        if ($file_type !== 'image/jpeg') {
            $errors['file'] = 'Загрузите файл в формате jpeg';
        }
    }

# проверяем что бы дата была больше или равна текущей
    if (!empty($_POST['date'])){
        $time_post = strtotime($_POST['date']);
        $time_now = strtotime(date('Y-m-d'));
        if ($time_post < $time_now) {
            $errors['date'] = 'Укажите правильную дату';
        }
    } else {
        $_POST['date'] = 0;
    }

# Проверяем на ошибки
    if (!empty($errors)) {
        $my_tasks_edit = one_task ($con, $user_id, $_POST['id']);
        $page_content = include_template('task-edit.php', ['projects' => $projects, 'my_tasks' => $my_tasks_edit, 'errors' => $errors]);
    } elseif (isset($_POST['edit'])) { // Отправляем запрос на изменение задачи
        $task['path'] = $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/' . $filename);
        $sql = "UPDATE task SET projects_id = ?, task_name = ?, task_description = ?, file = ?, file_name = ?, lifetime = ? WHERE id = ?";
        mysqli_prepare($con, $sql);
        $stmt = db_get_prepare_stmt($con, $sql, [$_POST['project'], $_POST['name'], $_POST['textarea'], $task['path'], $path, $_POST['date'], $_POST['id']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res){
            header("location: /index.php?project=" . $_POST['project'] . "&all&success-task");
            }

    }
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
        'title' => 'Редактирование задачи',
        'user_name' => $user_name,
        'is_auth' => $is_auth,
    ]);
    print($layout_content);
