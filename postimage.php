<?php
    require_once('func.php');
    require_once('init.php');
    $post = findPostByID($_GET['id']);
    header('Content-type: ' . $post['imagetype']);
    echo $post['image'];
?>