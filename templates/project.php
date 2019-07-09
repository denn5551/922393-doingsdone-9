
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
    <p>Здесь вы можете изменить название проекта или удалить проект.</p>
    <p>Что бы изменить название проекта, введите новое название в поле "Название проекта" и нажмите кнопку "Сохранить проект".</p>
    <form class="form" action="/controller/project.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? "form__input--error" : ''; ?>
            <label class="form__label" for="project_name">Название проекта<sup>*</sup></label>
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
            <button type="button" class="btn btn-outline-danger btn-lg" data-toggle="modal" data-target="#exampleModal">
                Удалить проект
            </button>
        </div>
            <div class="form__row form__row--controls col-lg-12 ">
                <input class="button" type="submit" name="back" value="Назад">
            </div>
        </div>

        <!-- Модальное окно -->
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
                        При удалении проекта также удалятся и все задачи.
                    </div>
                    <div class="modal-footer">
                        <div class="form__row form__row--controls col-lg-6 ">
                            <input class="button" id="start" type="submit" name="del-prodj" value="Удалить проект">
                        </div>
                        <div class="form__row form__row--controls col-lg-6 ">
                            <input class="button" id="start" type="submit" data-dismiss="modal" value="Отмена">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</main>
