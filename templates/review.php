<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <?php if ((int)$flag['flag'] === 0): ?>
            <form class="form" id="form" name="formrev">
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
                    <input class="button" type="submit" name="review" value="Отправить">
                </div>
                </div>
           </form>
            <?php else: ?>
                <p>Вы уже оставили отзыв. Спасибо!</p>
            <?php endif; ?>
            <section id="rew">
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
            </section>
        </div>
    </div>
    <?=include_template('pagination.php', [
        'pages' => $pages,
        'pages_count' => $pages_count,
        'cur_page' => $cur_page,
    ]); ?>
</div>

<script>
    document.forms.formrev.onsubmit = function (event) {
        // отключаем обновление стр. после нажатия на кнопку
        event.preventDefault();

        // создаем и присваеваем значение переменой
        var textarea = document.forms.formrev.textarea.value;

        var xhr = new XMLHttpRequest();

        xhr.open('POST', '/controller/review.php');

        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.responseType = 'json';

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {

                var flag = xhr.response;

                var d = document.getElementById("form");
                d.className += " visually-hidden";

                var main= document.querySelector("#rew");

                var str = '<div class="card border-primary mt-3 mb-3">\n'+
'                <div class="card-body">\n'+
'                    <h5 class="card-title">'+ flag.user_name +'</h5>\n'+
'                    <p class="card-text">'+ flag.textarea +'</p>\n'+
'                </div>\n'+
'                <div class="card-footer">\n'+
'                    <small class="text-muted">'+ flag.data +'</small>\n'+
'                </div>\n'+
'            </div>';

                main.innerHTML = str + main.innerHTML;
            }
        }

        xhr.send('textarea=' + textarea);
    }
</script>