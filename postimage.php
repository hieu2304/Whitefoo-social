<?php
    require_once('func.php');
    require_once('init.php');
    $post = findPostByID($_GET['id']);
    $imagetype = $post['imagetype'];
    if (isset($_GET['w']) && isset($_GET['h']))
    {
        header('Content-type: ' . $imagetype);
        echo $post['image'];
    }
    else
    {
        header('Content-type: ' . $imagetype);
        echo $post['image'];
    }
?>