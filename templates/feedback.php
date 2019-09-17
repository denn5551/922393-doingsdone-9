<div class="container">
    <div class="row">
        <h2>Обратная связь</h2>
    </div>
    <div class="row">
        <div class="col">
            <p>
                Если у вас есть предложения по улучшению проекта или вы хотите связаться с разработчиком, отправьте ваше сообщение используя форму ниже.
            </p>
            <div class="col-lg-9">
                <form class="form" action="/controller/feedback.php" method="post" autocomplete="off" enctype="multipart/form-data">
                <p>Имя: </p>
                <?php if (isset($errors['name'])) : ?>
                    <label class="form__message" for="basic-url"><?= $errors['name']; ?></label>
                <?php endif; ?>
                <div class="input-group mb-3">
                    <input type="text" name="name" id="basic-url" value="<?= strip_tags($user_name); ?>" class="form-control <?=isset($errors['name']) ? "form__input--error" : ''; ?>" placeholder="<?= strip_tags($user_data['user_name']); ?>" aria-label="Username" aria-describedby="basic-addon1">
                </div>

                <p>Почта:</p>
                <?php if (isset($errors['email'])) : ?>
                    <label class="form__message" for="basic-url"><?= $errors['email']; ?></label>
                <?php endif; ?>
                <div class="input-group mb-3">
                    <input type="text" name="email" value="<?= strip_tags($user_email); ?>" class="form-control <?=isset($errors['email']) ? "form__input--error" : ''; ?>" placeholder="<?= strip_tags($user_data['email']); ?>" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Сообщение:</label>

                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="155" name="textarea"></textarea>
                    <?php if (isset($errors['textarea'])) : ?>
                        <label class="form__message" for="basic-url"><?= $errors['textarea']; ?></label>
                    <?php endif; ?>

                </div>
                <div class="row mb-5">
                    <div class="form__row form__row--controls col-lg-6">
                        <input class="button" type="submit" name="button" value="Отправить">
                    </div>
                </div>

            </div>
                </form>
        </div>
    </div>
</div>
