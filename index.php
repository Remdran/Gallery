<?php include("includes/header.php"); ?>

<?php

$page = ! empty($_GET['page']) ? (int)$_GET['page'] : 1;

$picsPerPage = 4;

$totalCount = Photo::countAll();

$paginate = new Paginate($page, $picsPerPage, $totalCount);
$query = $paginate->dbQuery();
$photos = Photo::doQuery($query);

?>

<div class="row">
    <div class="col-md-12">

        <div class="thumbnails row">
            <?php foreach ($photos as $photo) : ?>
                <div class="col-xs-6 col-md-3">
                    <a href="photo.php?id=<?= $photo->getId(); ?>" class="thumbnail">
                        <img src="admin/<?= $photo->photoPath(); ?>" alt="" class="picture img-responsive">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row">
            <ul class="pager">
                <?php

                if ($paginate->totalPages() > 1) {
                    if ($paginate->allowNext()) {
                        echo "<li class='next'><a href='index.php?page={$paginate->next()}'>Next</a></li>";
                    }

                    for ($i = 1; $i <= $paginate->totalPages(); $i++) {
                        if ($i == $paginate->getPage()) {
                            echo "<li class='active'>{$i}</li>";
                        } else {
                            echo "<li class='unactive'><a href='index.php?page={$i}'>{$i}</a></li>";
                        }
                    }

                    if ($paginate->allowPrevious()) {
                        echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";
                    }
                }
                ?>
            </ul>
        </div>


    </div>
</div>     <!-- /.row -->




    <?php include("includes/footer.php"); ?>
