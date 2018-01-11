<?php include("includes/header.php"); ?>

<?php
if ( ! $session->isSignedIn()) {
    redirect('login.php');
}
?>

<?php

if (empty($_GET['id'])) {
    redirect('comments.php');
}

$comment = Comment::findById($_GET['id']);

if ($comment) {
    $comment->delete();
    $session->message("The comment has been deleted");
    redirect('comments.php');
} else {
    redirect('comments.php');
}


?>