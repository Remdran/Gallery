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

    </div>
</div>     <!-- /.row -->




    <?php include("includes/footer.php"); ?>
