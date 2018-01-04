<?php include("includes/header.php"); ?>

<?php
if ( ! $session->isSignedIn()) {
    redirect('login.php');
}
?>

<?php

if (empty($_GET['id'])) {
    redirect('users.php');
}

$comment = Comment::findById($_GET['id']);

if ($comment) {
    $comment->delete();
    redirect('comments.php');
} else {
    redirect('comments.php');
}


?>