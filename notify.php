<?php
require_once "vendor/autoload.php";
require_once('init.php');

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

// получаем пользователей у которых есть задачи на сегодня
$sql = "SELECT t.projects_id, t.`status`, u.id, u.user_name, u.email  FROM task t
   JOIN projects p ON p.id = t.projects_id 
	JOIN users u ON  p.user_id = u.id WHERE lifetime = CURRENT_DATE AND status = 0
	GROUP BY u.id ";

$res = mysqli_query($con, $sql);

if ($res && mysqli_num_rows($res)) {

    $users = mysqli_fetch_all($res, MYSQLI_ASSOC);

    foreach ($users as $user) {
        $user = $user;

        // получаем задачи конкретного пользователя
        $sql = "SELECT t.id, projects_id, task_name, status, file, file_name, lifetime  FROM task t
    JOIN projects p
    ON p.id = t.projects_id  WHERE user_id = $user[id] AND lifetime = CURRENT_DATE AND status = 0";

        $res = mysqli_query($con, $sql);

        $tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);

        $message = new Swift_Message();
        $message->setSubject("Уведомление от сервиса «Дела в порядке»");
        $message->setFrom(['keks@phpdemo.ru' => '«Дела в порядке»']);
        $message->setBcc($user['email'], $user['user_name']);
        $msg_content_body = false;

        foreach ($tasks as $task) {
            $msg_content_head = 'Уважаемый,' . ' ' . $user['user_name'] . '.' . "\r\n";
            $msg_content_body .= 'У вас запланирована задача' . ' ' . '"' . $task['task_name'] . '"' . ' ' . ' ' . 'на' . ' ' . $task['lifetime'] . "\r\n";
            $msg_content = $msg_content_head . $msg_content_body;
        }

        $message->setBody($msg_content, 'text/plain');

        $result = $mailer->send($message);
    }

    if ($result) {
        print("Рассылка успешно отправлена");
    } else {
        print("Не удалось отправить рассылку: " . $logger->dump());
    }

}