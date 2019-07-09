<?php //if ($pages_count > 1):?>
<!--    <nav aria-label="Page navigation example ">-->
<!--        <ul class="pagination justify-content-center mt-3">-->
<!---->
<!--            <li class="page-item --><?php //if ((integer)$cur_page === 1) : ?><!--disabled--><?php //endif; ?><!--">-->
<!--                <a class="page-link" href="index.php?page=--><?//= isset($_GET['page']) ? $_GET['page'] - 1 : '';?><!----><?//= $show_complete_tasks ? '&show_completed=1' : ''?><!--" tabindex="-1"><<</a>-->
<!--            </li>-->
<!--            --><?php //foreach ($pages as $page): ?>
<!--                <li class="page-item --><?php //if ($page == $cur_page): ?><!--active--><?php //endif; ?><!--"><a class="page-link" href="index.php?page=--><?//=$page;?><!----><?//= $show_complete_tasks ? '&show_completed=1' : ''?><!--">--><?//=$page;?><!--</a></li>-->
<!--            --><?php //endforeach; ?>
<!--            <li class="page-item --><?php //if ((integer)$_GET['page'] === (integer)array_pop($pages)) : ?><!--disabled--><?php //endif; ?><!--">-->
<!--                <a class="page-link" href="index.php?page=--><?//= isset($_GET['page']) ? $_GET['page'] + 1 : '';?><!-- --><?//= $show_complete_tasks ? '&show_completed=1' : ''?><!--">>> </a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </nav>-->
<?php //endif; ?>


<?php if ($pages_count > 1):?>
    <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?php if ((integer)$cur_page === 1) : ?>disabled<?php endif; ?>">
                <a class="page-link" href="<?=$_SERVER["REQUEST_URI"]?>?page=<?= isset($_GET['page']) ? $_GET['page'] - 1 : '';?><?= $show_complete_tasks ? '&show_completed=1' : ''?>" tabindex="-1"><<</a>
            </li>
            <?php for ($i=1; $i <= $pages_count; $i++) : ?>
                <li class="page-item <?php if ($_GET['page'] == $i): ?>active<?php endif; ?>"><a class="page-link" href="<?=$_SERVER["REQUEST_URI"]?>?page=<?=$i;?><?= $show_complete_tasks ? '&show_completed=1' : ''?>"><?=$i;?></a></li>
            <?php endfor ?>
            <li class="page-item <?php if ((integer)$_GET['page'] === (integer)array_pop($pages)) : ?>disabled<?php endif; ?>">
                <a class="page-link" href="index.php?page=<?= isset($_GET['page']) ? $_GET['page'] + 1 : '';?> <?= $show_complete_tasks ? '&show_completed=1' : ''?>">>> </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
