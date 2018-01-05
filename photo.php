<?php
require_once("admin/includes/init.php");

if (empty($_GET['id'])) {
    redirect("index.php");
}

$photo = Photo::findById($_GET['id']);

if (isset($_POST['submit'])) {
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);

    $createdComment = Comment::createComment($photo->getId(), $author, $body);

    if ($createdComment) {
        $createdComment->save();
        redirect("photo.php?id={$photo->getId()}");
    } else {
        $message = "There was a problem with submitting your comment";
    }
} else {
    $author = "";
    $body = "";
}

$comments = Comment::findComment($photo->getId());

?>
<?php include("includes/header.php"); ?>

    <div class="row">
        <div class="col-lg-12">

        <!-- Title -->
            <h1><?= $photo->getTitle(); ?></h1>

        <!-- Author -->
        <p class="lead">
            by <a href="#">Start Bootstrap</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

        <hr>

        <!-- Preview Image -->
            <img class="img-responsive" src="admin/<?= $photo->photoPath(); ?>" alt="">

        <hr>

        <!-- Post Content -->
            <p class="lead"><?= $photo->getCaption(); ?></p>
            <p><?= $photo->getDesc(); ?></p>


        <!-- Comments Form -->
        <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form" method="POST">
                <div class="form-group">
                    <input type="text" name="author" class="form-control" placeholder="Name">
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="body" placeholder="Your comment.."></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <?php foreach ($comments as $comment) : ?>
            <div class="media">
                <a href="#" class="pull-left">
                    <img src="http://placehold.it/64x64" alt="" class="media-object">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?= $comment->getAuthor(); ?></h4>
                    <?= $comment->getBody(); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>   <!-- /.row -->

<?php include("includes/footer.php"); ?>