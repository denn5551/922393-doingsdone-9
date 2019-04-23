<table class="tasks">
    <?php foreach ($my_tasks as $task): ?>
        <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
        <?php if (($show_complete_tasks) || (!$task["ready"])): ?>
            <tr class="tasks__item task <?= ($task["ready"])? 'task--completed': '' ?> <?= user_date($task["date"]) <= 24 && user_date($task["date"]) >= 0 ? 'task--important': '' ?>">
                <!--todo сделать ф-цию типа is_task_important($task_date) -->
                <td class="task__select">
                    <label class="checkbox task__checkbox ">
                        <input class="checkbox__input visually-hidden" type="checkbox" checked>
                        <span class="checkbox__text"><?= $task["task"]; ?></span>
                    </label>
                </td>
                <td class="task__date"><?= $task["date"]; ?></td>
                <td class="task__controls"></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>