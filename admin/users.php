<?php include("includes/header.php"); ?>
<?php
if ( ! $session->isSignedIn()) {
    redirect('login.php');
}
?>
<?php
$users = User::findAll();
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
                    <p class="bg-success"><?= $session->getMessage(); ?></p>
                    <h1 class="page-header">
                        Users
                    </h1>

                    <a href="add_user.php" class="btn btn-primary">Add User</a>

                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Photo</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $user->getId(); ?></td>
                                    <td><img class="admin-photo-thumbnail user_image" src="<?= $user->imagePath(); ?>"
                                             alt=""></td>
                                    <td><?= $user->getUsername(); ?>
                                        <div class="action_links">
                                            <a href="delete_user.php?id=<?= $user->getId(); ?>">Delete</a>
                                            <a href="edit_user.php?id=<?= $user->getId(); ?>">Edit</a>
                                        </div>
                                    </td>
                                    <td><?= $user->getFirstname(); ?></td>
                                    <td><?= $user->getLastname(); ?></td>
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
