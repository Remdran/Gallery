<?php include("includes/header.php"); ?>
<?php
if ( ! $session->isSignedIn()) {
    redirect('login.php');
}
?>
<?php
$photos = Photo::findAll();
?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <?php include("includes/top_nav.php"); ?>

        <?php include("includes/side_nav.php"); ?>

    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Photos
                    </h1>

                    <p class="bg-success"><?= $session->getMessage(); ?></p>

                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Id</th>
                                <th>File Name</th>
                                <th>Title</th>
                                <th>Size</th>
                                <th>Comments</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($photos as $photo) : ?>
                                <tr>
                                    <td>
                                        <img class="admin-photo-thumbnail" src="<?= $photo->photoPath(); ?>" alt="">
                                        <div class="action_links">
                                            <a href="delete_photo.php?id=<?= $photo->getId(); ?>">Delete</a>
                                            <a href="edit_photo.php?id=<?= $photo->getId(); ?>">Edit</a>
                                            <a href="../photo.php?id=<?= $photo->getId(); ?>">View</a>
                                        </div>
                                    </td>
                                    <td><?= $photo->getId(); ?></td>
                                    <td><?= $photo->getFilename(); ?></td>
                                    <td><?= $photo->getTitle(); ?></td>
                                    <td><?= $photo->getSize(); ?></td>
                                    <td>
                                        <a href="photo_comment.php?id=<?= $photo->getId(); ?>">
                                            <?php
                                            $comment = Comment::findComment($photo->getId());
                                            echo count($comment);
                                            ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?><?php
