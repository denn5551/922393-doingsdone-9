<div class="container">
    <h1>Личный кабинет</h1>
    <form class="form" action="user.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <?php foreach ($users_data as $user_data): ?>
        <div class="col-lg-9">
           <p>Дата регистрации: <?= $user_data['date_reg']; ?></p>
           <p>Имя: </p>
            <?php if (isset($errors['name'])) : ?>
                <label class="form__message" for="basic-url"><?= $errors['name']; ?></label>
            <?php endif; ?>
            <div class="input-group mb-3">
                <input type="text" name="name" id="basic-url" value="<?= strip_tags($user_data['user_name']); ?>" class="form-control <?=isset($errors['name']) ? "form__input--error" : ''; ?>" placeholder="<?= strip_tags($user_data['user_name']); ?>" aria-label="Username" aria-describedby="basic-addon1">
            </div>

           <p>Почта:</p>
            <?php if (isset($errors['email'])) : ?>
                <label class="form__message" for="basic-url"><?= $errors['email']; ?></label>
            <?php endif; ?>
            <div class="input-group mb-3">
                <input type="text" name="email" value="<?= strip_tags($user_data['email']); ?>" class="form-control <?=isset($errors['email']) ? "form__input--error" : ''; ?>" placeholder="<?= strip_tags($user_data['email']); ?>" aria-label="Username" aria-describedby="basic-addon1">
            </div>
        </div>
        <?php endforeach; ?>
        <div class="row">
            <div class="form__row form__row--controls col-lg-6">
                <input class="button" type="submit" name="user_edit" value="Сохранить" >
            </div>
            <div class="form__row form__row--controls col-lg-6">
                <input class="button" type="submit" name="user_cancel" value="Отмена">
            </div>
        </div>
    </form>
</div>



