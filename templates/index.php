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

    <?php if (isset($_GET['success_del'])): ?>
        <div class="alert alert-success" role="alert">
            Задача удалена!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success-task'])): ?>
        <div class="alert alert-success" role="alert">
            Задача изменена успешно!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success_project'])): ?>
        <div class="alert alert-success" role="alert">
            Проект добавлен успешно!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success_del_proj'])): ?>
        <div class="alert alert-success" role="alert">
            Проект удален успешно!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form class="search-form" action="/controller/srch.php" method="get" autocomplete="off">
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
            <a href="index.php?notime<?= isset($_GET['project']) ? '&project=' . $_GET['project'] : '' ?>"
               class="tasks-switch__item <?= isset($_GET['notime']) ? 'tasks-switch__item--active' : ''; ?>">Без срока</a>
        </nav>
        <?php if (isset($_GET['all']) || isset($_GET['page'])) : ?>
        <label class="checkbox">
            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed"
                   type="checkbox" <?= (!empty($show_complete_tasks)) ? 'checked' : '' ?> >
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
        <?php endif; ?>
    </div>
    <?php if (empty($my_tasks)) : ?>
        <p>В этом разделе нет задач.</p>
        <img src="/img/not-tasks.jpg" alt="not-tasks" width="400" style="display: block; margin: auto">
    <?php endif; ?>
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
                            <a class="download-link" data-fancybox="images" href="<?= "uploads/" . $task['file'] ?>"  data-caption="fox1"><?= $task["file_name"]; ?></a>
<!--                            <a class="download-link" href="--><?//= "uploads/" . $task['file'] ?><!--">--><?//= $task["file_name"]; ?><!--</a>-->
                        <?php endif; ?>
                    </td>
                    <td class="task__date"><?= (integer)$task["lifetime"] === 0 ? 'Бессрочно' : $task["lifetime"]; ?></td>
                    <td class="task__controls">
                        <a href="/controller/task.php?task-edit=<?= $task['id']; ?>&id=<?=  $task["projects_id"] ?>" class="tasks-delete" ><img src="/img/edit.jpg" alt="" width="15px"></a>
                        <a href="#" class="tasks-delete " data-toggle="modal" data-target="#exampleModal">Х</a>
                    </td>
                </tr>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Внимание!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Вы действительно хотите удалить задачу?</p>
                                <p>При удалении задачи востановить ее будет невозможно!</p>
                            </div>
                            <div class="modal-footer">
                                <div class="form__row form__row--controls col-lg-6 ">
                                    <a href="index.php?delete&id=<?= $task['id']; ?>&file=<?= $task['file']; ?>" class="tasks-delete ">
                                        <input class="button" id="start" type="submit" name="del-prodj" value="Удалить задачу">
                                    </a>
                                </div>
                                <div class="form__row form__row--controls col-lg-6 ">
                                    <input class="button" id="start" type="submit" data-dismiss="modal" value="Отмена">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </table>


<?=include_template('pagination.php', [
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
    'show_complete_tasks' => $show_complete_tasks
]); ?>