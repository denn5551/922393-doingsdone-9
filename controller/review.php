<?php
require_once('../helpers.php');
require_once('../functions.php');
require_once('../init.php');

if ($is_auth) {

    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    // добавляем отзыв
    if ($_POST['textarea']) {
        $sql = 'INSERT INTO review (date_review, user_name, user_id ,review, flag)  
        VALUES (NOW(), ?, ?, ?, 1)';
        $stmt = db_get_prepare_stmt($con, $sql, [$user_name, $user_id, $_POST['textarea']]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        $data = date("Y.m.d");
        print json_encode ([ 'textarea' => $_POST['textarea'], 'user_name' => $user_name, 'data' => $data]);
        exit;
    }


    # Получаем flag и если flag = 1 скрываем форму отзывов
    $sql = 'SELECT  flag FROM review WHERE user_id =' . $user_id;

    $result = mysqli_query($con, $sql);

    $flag = mysqli_fetch_assoc($result);


    # постраничный вывод
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 5;

    $sql = 'SELECT COUNT(*) AS id FROM review';

    $result = mysqli_query($con, $sql);

    $items_count = mysqli_fetch_assoc($result)['id'];

    $pages_count = ceil($items_count / $page_items);

    $offset = ($cur_page - 1) * $page_items;

    $pages = range(1, $pages_count);

    // запрос на показ отзывов
    $sql = 'SELECT date_review, user_name, user_id, review  FROM review ORDER BY id DESC LIMIT ? OFFSET ?';

    $stmt = db_get_prepare_stmt($con, $sql, [$page_items, $offset]);
    mysqli_stmt_execute($stmt);

    $reviews = mysqli_stmt_get_result($stmt);

    $page_content = include_template('review.php',
        [
            'reviews' => $reviews,
            'user_is' => $user_id,
            'flag' => $flag,
            'pages' => $pages,
            'pages_count' => $pages_count,
            'cur_page' => $cur_page
        ]);

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
    'title' => 'Отзывы',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
]);
print($layout_content);