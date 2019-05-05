<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post" autocomplete="off">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= ($show_complete_tasks)? 'checked': '' ?> >
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

<table class="tasks">
    <?php foreach ($my_tasks as $task): ?>
    <!-- показываем блок если GET пустой или id проекта равно id GET запроса для вывода товаров в выбранном проекте  -->
        <?php if (!isset($_GET['project']) || $task['projects_id'] === $_GET['project']): ?>
            <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
            <?php if ($show_complete_tasks || !$task["status"]): ?>
                <tr class="tasks__item task <?= ($task["status"]) ? 'task--completed' : '' ?> <?= is_task_important($task["lifetime"]) ? 'task--important' : '' ?>">
                    <td class="task__select">
                        <label class="checkbox task__checkbox ">
                            <input class="checkbox__input visually-hidden" type="checkbox" checked>
                            <span class="checkbox__text"><?= $task["task_name"]; ?></span>
                        </label>
                    </td>

                    <td class="task__date"><?= $task["lifetime"]; ?></td>
                    <?php if (isset($task['file'])) : ?>
                        <td class="task__file"><a class="download-link" href="<?= "uploads/" . $task['file'] ?>"></a></td>
                    <?php endif; ?>
                    <td class="task__controls"></td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</table>