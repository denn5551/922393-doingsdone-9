<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

/** @var TYPE_NAME $projects */
$projects = [
    "inbox" => "Входящие",
    "study" => "Учеба",
    "work" => "Работа",
    "housework" => "Домашние дела",
    "car" => "Авто"
];

/** @var TYPE_NAME $my_tasks */
$my_tasks = [
    [
        "task" => "Собеседование в IT компании",
        "date" => "01.12.2018",
        "category" => $projects['work'],
        "ready" => false
    ], [
        "task" => "Выполнить тестовое задание",
        "date" => "25.12.2018",
        "category" => $projects['work'],
        "ready" => false
    ], [
        "task" => "Сделать задание первого раздела",
        "date" => "21.12.2018",
        "category" => $projects['study'],
        "ready" => true
    ], [
        "task" => "Встреча с другом",
        "date" => "22.12.2018",
        "category" => $projects['inbox'],
        "ready" => false
    ], [
        "task" => "Купить корм для кота",
        "date" => "Нет",
        "category" => $projects['housework'],
        "ready" => false
    ], [
        "task" => "Заказать пиццу",
        "date" => "Нет",
        "category" => $projects['housework'],
        "ready" => false
    ],
];

