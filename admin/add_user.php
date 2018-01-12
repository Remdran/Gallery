<?php include("includes/header.php"); ?>
<?php
if ( ! $session->isSignedIn()) {
    redirect('login.php');
}
?>
<?php

if (isset($_POST['submit'])) {
    $user = new User();

    if ($user) {
        $user->setUsername($_POST['username']);
        $user->setFirstName($_POST['first_name']);
        $user->setLastName($_POST['last_name']);
        $user->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT));

        $user->setFile($_FILES['user_image']);

        $user->saveImage();
        $user->save();
        $session->message("The user: {$user->getUsername()} has been added");
        redirect("users.php");
    }
}
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
                        Add User
                        <small>Subheading</small>
                    </h1>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="col-md-6 col-md-offset-3">

                            <div class="form-group">
                                <input type="file" name="user_image">
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control"
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control"
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary"
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?><?php
