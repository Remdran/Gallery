<?php include("includes/header.php"); ?>
<?php
if ( ! $session->isSignedIn()) {
    redirect('login.php');
}
?>
<?php

if (empty($_GET['id'])) {
    redirect("users.php");
}

$user = User::findById($_GET['id']);

if (isset($_POST['update'])) {
    if ($user) {
        $user->setUsername($_POST['username']);
        $user->setFirstName($_POST['first_name']);
        $user->setLastName($_POST['last_name']);
        $user->setPassword($_POST['password']);

        $user->setFile($_FILES['user_image']);

        if ($user->saveImage()) {
            $message = "User added successfully";
        } else {
            $message = join("<br>", $user->errors);
        }
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
                    Edit User
                    <small>Subheading</small>
                </h1>

                <div class="col-md-6">
                    <img class="img-responsive" src="<?= $user->imagePath() ?>" alt="">
                </div>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="col-md-6">

                        <div class="form-group">
                            <input type="file" name="user_image">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control"
                                   value="<?= $user->getUsername(); ?>">
                        </div>

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="<?= $user->getFirstName(); ?>"
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="<?= $user->getLastName(); ?>"
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control"
                                   value="<?= $user->getPassword(); ?>">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="update" class="btn btn-primary" value="Update"
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

<?php include("includes/footer.php"); ?>

