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
    <form class="form col-lg-9" action="task.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <?php foreach ($my_tasks as $my_task): ?>
        <div class="col-lg-9">
           <p>Задача: <?= strip_tags($my_task['task_name']); ?></p>
           <p>Описание: <?= strip_tags($my_task['task_description']); ?></p>
           <p>Статус: <?= strip_tags($my_task['status']); ?></p>
           <p>Завершить: <?= strip_tags($my_task['lifetime']); ?></p>
        </div>
        <?php endforeach; ?>
        <div class="row">
            <div class="form__row form__row--controls col-lg-6">
                <input class="button" type="submit" name="task-edit" value="Редактировать" >
            </div>
        </div>
    </form>
</div>