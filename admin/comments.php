<?php include("includes/header.php"); ?>
<?php
if ( ! $session->isSignedIn()) {
    redirect('login.php');
}
?>
<?php
$comments = Comment::findAll();
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
                        Comments
                    </h1>

                    <p class="bg-success"><?= $session->getMessage(); ?></p>

                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Body</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($comments as $comment) : ?>
                                <tr>
                                    <td><?= $comment->getId(); ?></td>
                                    <td><?= $comment->getAuthor(); ?>
                                        <div class="action_links">
                                            <a href="delete_comment.php?id=<?= $comment->getId(); ?>">Delete</a>
                                        </div>
                                    </td>
                                    <td><?= $comment->getBody(); ?></td>
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
