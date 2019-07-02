<main class="content__main">
    <h2 class="content__main-heading">Добавление проекта</h2>

    <form class="form" action="./project.php" method="post" autocomplete="off">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? "form__input--error" : ''; ?>
            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            <?php foreach ($projects as $project): ?>

            <?php if ($project['id'] === (integer)$_GET['id']) : ?>
            <input class="form__input <?= $classname; ?>" type="text" name="name" id="project_name" value=""
                   placeholder="<?= $project['projects_name'] ?>">
            <?php endif; ?>
            <?php endforeach; ?>
            <p class="form__message"><?= $errors['name'] ?? ''; ?></p>
        </div>
        <div class="row mb-5">
        <div class="form__row form__row--controls col-lg-6 ">
            <input class="button" type="submit" name="save-prodj" value="Сохранить">
        </div>
       <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
        <div class="form__row form__row--controls col-lg-6 ">
            <input class="button" type="submit" name="del-prodj" value="Удалить">
        </div>
        </div>
    </form>
</main>
