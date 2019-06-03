<?php
require_once('helpers.php');

session_start();

unset($_SESSION['user']);

$page_content = include_template('guest.php');

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная'
]);
print($layout_content);