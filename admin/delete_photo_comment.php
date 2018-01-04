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
    $photo_id = $comment->getPhotoId();
    redirect("photo_comment.php?id={$photo_id}");
} else {
    redirect('comments.php');
}


?>