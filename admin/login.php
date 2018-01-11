<?php require_once("includes/header.php"); ?>

<?php
if ($session->isSignedIn()) {
    redirect('index.php');
}

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user = User::verifyUser($username, $password);

    if ($user) {
        $session->login($user);
        redirect('index.php');
    } else {
        $message = 'Your password or username was incorrect';
    }
} else {
    $username = "";
    $password = "";
    $message = "";
}

?>

<div class="col-md-4 col-md-offset-3">
    <h4 class="bg-danger"><?= $message; ?></h4>
    <form id="login-form" action="" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="<?= htmlentities($username) ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
        </div>
    </form>
</div>
