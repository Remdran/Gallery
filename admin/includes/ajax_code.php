<?php require_once("init.php"); ?>
<?php

$user = new User();

if (isset($_POST['imgName'])) {
    $user->ajaxSaveUserImg($_POST['imgName'], $_POST['userId']);
}

if (isset($_POST['photoId'])) {
    Photo::displayData($_POST['photoId']);
}


