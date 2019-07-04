
<main class="content__main">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" role="alert">
            Название проекта изменено успешно!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <h2 class="content__main-heading">Редактирование проекта</h2>
    <form class="form" action="/controller/project.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? "form__input--error" : ''; ?>
            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            <?php foreach ($projects as $project): ?>

            <input class="form__input <?= $classname; ?>" type="text" name="name" id="project_name" value="<?= $project['projects_name'] ?>"
                   placeholder="<?= $project['projects_name'] ?>">
            <!--Скрытое поле передает id проекта -->
                <input type="hidden" name="id" value="<?= $project['id']; ?>">
            <?php endforeach; ?>
            <p class="form__message"><?= $errors['name'] ?? ''; ?></p>
        </div>
        <div class="row mb-5">
        <div class="form__row form__row--controls col-lg-6 ">
            <input class="button" type="submit" name="save-prodj" value="Сохранить проект">
        </div>

        <div class="form__row form__row--controls col-lg-6 ">
            <input class="button" type="submit" name="del-prodj" value="Удалить проект">
        </div>
            <div class="form__row form__row--controls col-lg-12 ">
                <input class="button" type="submit" name="back" value="Назад">
            </div>
        </div>
    </form>
</main>
