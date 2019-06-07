<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" role="alert">
            Задача добавлена успешно!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form class="search-form" action="srch.php" method="get" autocomplete="off">
        <input class="search-form__input" type="text" name="search" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="index.php?all<?= isset($_GET['project']) ? '&project=' . $_GET['project'] : '' ?>"
               class="tasks-switch__item <?= isset($_GET['all']) ? 'tasks-switch__item--active' : ''; ?>">Все задачи</a>
            <a href="index.php?today<?= isset($_GET['project']) ? '&project=' . $_GET['project'] : '' ?>"
               class="tasks-switch__item <?= isset($_GET['today']) ? 'tasks-switch__item--active' : ''; ?>">Повестка
                дня</a>
            <a href="index.php?tomorrow<?= isset($_GET['project']) ? '&project=' . $_GET['project'] : '' ?>"
               class="tasks-switch__item <?= isset($_GET['tomorrow']) ? 'tasks-switch__item--active' : ''; ?>">Завтра</a>
            <a href="index.php?overdue<?= isset($_GET['project']) ? '&project=' . $_GET['project'] : '' ?>"
               class="tasks-switch__item <?= isset($_GET['overdue']) ? 'tasks-switch__item--active' : ''; ?>">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed"
                   type="checkbox" <?= (!empty($show_complete_tasks)) ? 'checked' : '' ?> >
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <?php if (isset($my_tasks)): ?>
            <?php foreach ($my_tasks as $task): ?>

                <tr class="tasks__item task <?= ($task["status"]) ? 'task--completed' : '' ?> <?= is_task_important($task["lifetime"]) ? 'task--important' : '' ?>">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden" type="checkbox" name="check"
                                   value="<?= $task['id']; ?>" <?= $task["status"] ? 'checked' : '' ?>>
                            <span class="checkbox__text"><?= strip_tags($task["task_name"]); ?>

                                <?php if (!empty($task['task_description'])) : ?>
                                <br><p class="task-description"> <?= strip_tags($task["task_description"]); ?> </p>
                                <?php endif; ?>
                            </span>
                        </label>
                    </td>
                    <td class="task__file">
                        <?php if (isset($task['file'])) : ?>
                            <a class="download-link" href="<?= "uploads/" . $task['file'] ?>"><?= $task["file_name"]; ?></a>
                        <?php endif; ?>
                    </td>
                    <td class="task__date"><?= (integer)$task["lifetime"] === 0 ? 'Бессрочно' : $task["lifetime"]; ?></td>
                    <td class="task__controls"><a href="index.php?delete&id=<?= $task['id']; ?>" class="tasks-delete ">&times;</a></td>
                </tr>

            <?php endforeach; ?>
        <?php endif ?>
    </table>
    <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>