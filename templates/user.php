
<div class="container">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" role="alert">
            Данные обновленны успешно!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <h1>Личный кабинет</h1>
    <form class="form" action="user.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <?php foreach ($users_data as $user_data): ?>
        <div class="col-lg-9">
           <p>Дата регистрации: <?= strip_tags($user_data['date_reg']); ?></p>
           <p>Имя: <?= strip_tags($user_data['user_name']); ?></p>
           <p>Почта: <?= strip_tags($user_data['email']); ?></p>
        </div>
        <?php endforeach; ?>
        <div class="row">
            <div class="form__row form__row--controls col-lg-6">
                <input class="button" type="submit" name="user_data" value="Редактировать" >
            </div>
        </div>
    </form>
</div>



