<?php
require_once ('vendor/autoload.php');
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

if ($is_auth) {
    $user_id = $_SESSION['user']['id'];

    $user_name = $_SESSION['user']['user_name'];

    $user_email = $_SESSION['user']['email'];

    $projects = get_categories($con, $user_id);

    $my_tasks = get_tasks($con, $user_id, 0, false);

    $page_content = include_template('feedback.php', ['user_name' => $user_name, 'user_email' => $user_email]);

    if (isset($_POST['button'])) {
        $required = ['name', 'email', 'textarea'];

        $errors = [];
        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        if (!empty($errors)) {
            $page_content = include_template('feedback.php', ['user_name' => $user_name, 'user_email' => $user_email, 'errors' => $errors]);
        } else {

// Конфигурация траспорта
            $transport = new Swift_SmtpTransport('yandex.ru', 465);
            $transport->setUsername("kcc-kem@yandex.ru");
            $transport->setPassword("bLN-riL-Sds-5uW");

            $mailer = new Swift_Mailer($transport);

//        $logger = new Swift_Plugins_Loggers_ArrayLogger();
//        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
// Формирование сообщения
            $message = new Swift_Message();
            $message->setSubject("Самые горячие гифки за этот месяц");
            $message->setFrom(['denn5551@yandex.ru' => 'GifTube']);
            $message->addBcc('kcc-kem@yandex.ru');
            $message->setBody('сообщение', 'text/plain');
// Отправка сообщения
            $mailer = new Swift_Mailer($transport);
            $result = $mailer->send($message);

        }

    }


}else {
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
    'title' => 'Обратная связь',
    'user_name' => $user_name,
    'is_auth' => $is_auth,
]);
print($layout_content);
