<div class="container">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" role="alert">
            Данные обновленны успешно!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <h1>Редактирование задачи</h1>
    <p>Если вы хотите изменить название, описание, дату или проект, то нажмите кнопку "Редактировать" и внесите изменения. </p>

        <?php foreach ($my_tasks as $task): ?>
        <div class="col-lg-9">
           <p>Задача: <?= strip_tags($task['task_name']); ?></p>
           <p>Описание: <?= strip_tags($task['task_description']); ?></p>
           <p>Статус: <?= strip_tags($task['status']); ?></p>
           <p>Завершить: <?= strip_tags($task['lifetime']); ?></p>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <a href="task.php?task-edit=<?= $task['id']; ?>" class="tasks-delete" >Редактировать</a>
            </div>
        </div>
        <?php endforeach; ?>
</div>