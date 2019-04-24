<table class="tasks">
    <?php foreach ($my_tasks as $task): ?>
        <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
    <!-- $task["status"] показвает выполненные задачи-->
        <?php if (!$task["status"]): ?>
            <tr class="tasks__item task <?= ($task["status"])? 'task--completed': '' ?> <?= user_important($task["lifetime"])?>">
                <!--todo сделать ф-цию типа is_task_important($task_date) -->
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
    <?php endforeach; ?>
</table>