<?php if ($pages_count > 1 && isset($_GET['project'])) : ?>
    <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?=(integer)$cur_page === 1 ? 'disabled' : ' ' ?>">
                <a class="page-link" href="/index.php?project=<?=$_GET['project'];?>&all&page=<?= isset($_GET['page']) ? $_GET['page'] - 1 : '';?><?= $show_complete_tasks ? '&show_completed=1' : ''?>" tabindex="-1"><<</a>
            </li>
            <?php for ($i=1; $i <= $pages_count; $i++) : ?>
                <li class="page-item <?= (integer) $_GET['page'] === $i ? 'active' : '' ?>"><a class="page-link" href="/index.php?project=<?=$_GET['project'];?>&all&page=<?=$i;?><?= $show_complete_tasks ? '&show_completed=1' : ''?>"><?=$i;?></a></li>
            <?php endfor ?>
            <li class="page-item <?= ((integer)$_GET['page'] === (integer)array_pop($pages)) ? 'disabled' : '' ?>">
                <a class="page-link" href="/index.php?project=<?=$_GET['project'];?>&all&page=<?= isset($_GET['page']) ? $_GET['page'] + 1 : '';?> <?= $show_complete_tasks ? '&show_completed=1' : ''?>">>> </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php if ($pages_count > 1 && empty($_GET['project']) && empty($_GET['page'])) : ?>
    <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?=(integer)$cur_page === 1 ? 'disabled' : ' ' ?>">
                <a class="page-link" href="/index.php?all&page=<?= isset($_GET['page']) ? $_GET['page'] - 1 : '';?><?= $show_complete_tasks ? '&show_completed=1' : ''?>" tabindex="-1"><<</a>
            </li>
            <?php for ($i=1; $i <= $pages_count; $i++) : ?>
                <li class="page-item <?= (integer) $_GET['page'] === $i ? 'active' : '' ?>"><a class="page-link" href="/index.php?all&page=<?=$i;?><?= $show_complete_tasks ? '&show_completed=1' : ''?>"><?=$i;?></a></li>
            <?php endfor ?>
            <li class="page-item <?= ((integer)$_GET['page'] === (integer)array_pop($pages)) ? 'disabled' : '' ?>">
                <a class="page-link" href="/index.php?all&page=<?= isset($_GET['page']) ? $_GET['page'] + 1 : '';?> <?= $show_complete_tasks ? '&show_completed=1' : ''?>">>> </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php if ($pages_count > 1 && isset($_GET['page']) && empty($_GET['project'])): ?>
    <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?=(integer)$cur_page === 1 ? 'disabled' : ' ' ?>">
                <a class="page-link" href="/controller/review.php?page=<?= isset($_GET['page']) ? $_GET['page'] - 1 : '';?>" tabindex="-1"><<</a>
            </li>
            <?php for ($i=1; $i <= $pages_count; $i++) : ?>
                <li class="page-item <?= (integer) $_GET['page'] === $i ? 'active' : '' ?>"><a class="page-link" href="/controller/review.php?page=<?=$i;?><?= $show_complete_tasks ? '&show_completed=1' : ''?>"><?=$i;?></a></li>
            <?php endfor ?>
            <li class="page-item <?= ((integer)$_GET['page'] === (integer)array_pop($pages)) ? 'disabled' : '' ?>">
                <a class="page-link" href="/controller/review.php?page=<?= isset($_GET['page']) ? $_GET['page'] + 1 : '';?> ">>> </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
