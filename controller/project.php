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
        $required = ['name'];
        $errors = [];
        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        $name = mysqli_real_escape_string($con, $_POST['name']);
        $sql = "SELECT id FROM projects WHERE projects_name = '$name'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['name'] = 'Задача с таким названием уже существует.';
        }

        if (!empty($errors)) {
            $page_content = include_template('project.php', ['projects' => $projects, 'errors' => $errors]);
        } else {
            $sql = "UPDATE projects SET projects_name = ? WHERE id = ?";
            mysqli_prepare($con, $sql);
            $stmt = db_get_prepare_stmt($con, $sql, [$_POST['name'], $user_id]);
            $res = mysqli_stmt_execute($stmt);
            if ($res){
                header("Location: /controller/project.php?success=true");
            }
        }

    }



        $page_content = include_template('project.php', ['projects' => $projects]);

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
    'title' => 'Дела впорядке',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
]);
print($layout_content);
