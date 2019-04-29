<table class="tasks">
    <?php foreach ($my_tasks as $task): ?>
        <?php if (isset($_GET['project'])): ?>
            <?php if (($task['projects_id'] === $_GET['project'])): ?>
                <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
                <?php if (($show_complete_tasks) || (!$task["status"])): ?>
                    <tr class="tasks__item task <?= ($task["status"]) ? 'task--completed' : '' ?> <?= is_task_important($task["lifetime"]) ? 'task--important' : '' ?>">
                        <td class="task__select">
                            <label class="checkbox task__checkbox ">
                                <input class="checkbox__input visually-hidden" type="checkbox" checked>
                                <span class="checkbox__text"><?= $task["task_name"]; ?></span>
                            </label>
                        </td>
                        <td class="task__date"><?= $task["lifetime"]; ?></td>
                        <td class="task__controls"></td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

        <?php endif; ?>
    <?php endforeach; ?>

</table>