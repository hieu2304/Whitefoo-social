<?php
    require_once('func.php');
    require_once('init.php');
    $user = findUserByID($_GET['id']);
    header('Content-type: ' . $user['pfptype']);
    echo $user['pfp'];
?>