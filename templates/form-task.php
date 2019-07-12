<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <?php if (isset($_GET['success'])): ?>
        <div id="my-alert" class="alert alert-success" role="alert">
            Задача добавлена успешно!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form class="form" action="add.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? "form__input--error" : ''; ?>
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?= $classname; ?>" type="text" name="name" id="name"
                   value="<?= $_POST['name'] ?? ''; ?>" placeholder="Введите название">
            <?php if (isset($errors['name'])) : ?>
                <p class="form__message"><?= $errors['name']; ?> </p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select" name="project" id="project">
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['id']; ?>"<?= (integer)$_POST['project'] === $project['id'] ? 'selected' : ''; ?><?= isset($_GET['id']) && (integer)$_GET['id'] === $project['id'] ? 'selected' : ''; ?>><?= strip_tags($project['projects_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Описание проекта</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="155" name="textarea"></textarea>
        </div>

        <div class="form__row">
            <?php $classname = isset($errors['date']) ? "form__input--error" : ''; ?>
            <label class="form__label" for="date">Дата выполнения</label>
            <input class="form__input form__input--date <?= $classname; ?>" type="text" name="date" id="date"
                   value="<?= !empty($_POST['date']) ? $_POST['date'] : ''; ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <?php if (isset($errors['date'])) : ?>
                <p class="form__message"><?= $errors['date']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="file" id="file" value="">

                <label class="button button--transparent" for="file">
                    <span>Выберите файл</span>
                </label>
                <?php if (isset($errors['file'])) : ?>
                    <p class="form__message"><?= $errors['file']; ?></p>
                <?php endif; ?>
            </div>
        </div>
                <div class="row mb-5">
                    <div class="form__row form__row--controls col-lg-6">
                        <input class="button" type="submit" name="button1" value="Добавить">
                    </div>

                    <div class="form__row form__row--controls col-lg-6">
                        <input class="button" type="submit" name="button2" value="Добавить еще">
                    </div>
            </div>
    </form>

</main>