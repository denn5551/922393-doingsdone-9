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
        "date" => "21.04.2019",
        "category" => $projects['work'],
        "ready" => false
    ], [
        "task" => "Выполнить тестовое задание",
        "date" => "19.04.2019",
        "category" => $projects['work'],
        "ready" => false
    ], [
        "task" => "Сделать задание первого раздела",
        "date" => "18.03.2019",
        "category" => $projects['study'],
        "ready" => true
    ], [
        "task" => "Встреча с другом",
        "date" => "18.04.2019",
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

