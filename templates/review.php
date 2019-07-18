<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php if ((int)$flag['flag'] === 0): ?>
<!--            <form class="form" action="/controller/review.php" method="post" autocomplete="off" enctype="multipart/form-data">-->
                <div class="row ">
                    <div class="col-sm-10">
                        <p>Оставьте отзыв о проекте.</p>
                    </div>
                    <div class="form-group col-sm-10">
                        <label for="exampleFormControlTextarea1">Ваш отзыв</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="155" name="textarea"></textarea>
                    </div>
                </div>
                <div class="row">
                <div class="form__row form__row--controls col-lg-6">
                    <input class="button" type="submit" name="rev" value="Отправить">
                    <input class="visually-hidden" type="text" name="review" id="file" value="review">
                </div>
                </div>
<!--            </form>-->
            <?php else: ?>
                <p>Вы уже оставили отзыв. Спасибо!</p>
            <?php endif; ?>

            <?php foreach ($reviews as $review): ?>
            <div class="card border-primary mt-3 mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= strip_tags($review['user_name']); ?></h5>
                    <p class="card-text"><?= strip_tags($review['review']); ?></p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><?= $review['date_review']; ?></small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?=include_template('pagination.php', [
        'pages' => $pages,
        'pages_count' => $pages_count,
        'cur_page' => $cur_page,
    ]); ?>
</div>

<script>
    $(document).ready(function () {
        $('input.button').on('click', function () {
            var textarea = $('#exampleFormControlTextarea1').val();
            var button = $('input.visually-hidden').val();
            console.log (textarea, button);

            $.ajax({
                method: "POST",
                url: "/controller/review.php",
                data: { textarea: textarea, review: button },
                success:function() {
                    document.location.reload(true);
                }
            });
            $('#exampleFormControlTextarea1').val('');


        })
    })
</script>