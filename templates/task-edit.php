<main class="content__main">
    <h2 class="content__main-heading">Редактирование задачи</h2>
<p>Здесь вы можете отредактировать вашу задачу. Для этого измените одно из полей или все поля сразу.</p>
<p>Если вы хотите перенести задачу в другой проект, то просто выбирете новый проект в соответствующем поле.</p>
    <?php if (isset($_GET['success'])): ?>
        <div id="my-alert" class="alert alert-success" role="alert">
            Файл удален!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            $(function(){
                window.setTimeout(function(){
                    $('#my-alert').alert('close');
                },5000);
            });
        </script>
    <?php endif; ?>

    <?php foreach ($my_tasks as $task): ?>

    <form class="form" action="/controller/task.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? "form__input--error" : ''; ?>
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?= $classname; ?>" type="text" name="name" id="name"
                   value="<?= $task['task_name']; ?>" placeholder="Введите название">

            <?php if (isset($errors['name'])) : ?>
                <p class="form__message"><?= $errors['name']; ?> </p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select" name="project" id="project">
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['id']; ?>" <?= $task['projects_id'] === $project['id'] ? 'selected' : ''; ?>><?= strip_tags($project['projects_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Описание проекта</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="155" name="textarea" placeholder=""><?= $task['task_description']; ?></textarea>
            <?php if (isset($errors['textarea'])) : ?>
                <p class="form__message"><?= $errors['textarea']; ?> </p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <?php $classname = isset($errors['date']) ? "form__input--error" : ''; ?>
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date <?= $classname; ?>" type="text" name="date" id="date"
                   value="<?= (integer)$task["lifetime"] === 0 ? 'Бессрочно' : $task["lifetime"]; ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <?php if (isset($errors['date'])) : ?>
                <p class="form__message"><?= $errors['date']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="file" id="file" value="">

                <?php if (empty($task['file'])) : ?>
                <label class="button button--transparent" for="file">
                    <span>Выберите файл</span>
                </label>
                <?php endif; ?>

                <?php if (!empty($task['file'])) : ?>
                    <input type="hidden" name="file_name" value="<?= $task["file_name"]; ?>">
                    <a data-fancybox="images"  href="<?= "uploads/" . $task['file'] ?>"  data-caption="fox1"><?= $task["file_name"]; ?></a>
                    <a href="task.php?delete-file=<?= $task['file']; ?>&id=<?= $task['id']; ?>" class="tasks-delete ">&times;</a>
                <?php endif; ?>

                <?php if (isset($errors['file'])) : ?>
                    <p class="form__message"><?= $errors['file']; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <!--Скрытое поле передает id задачи -->
        <input type="hidden" name="id" value="<?= $task['id']; ?>">
        <div class="row mb-5">
            <div class="form__row form__row--controls col-lg-6">
                <input class="button" type="submit" name="edit" value="Сохранить">
            </div>
        </div>
    </form>

</main>
