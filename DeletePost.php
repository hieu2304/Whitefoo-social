<?php require_once('init.php');
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>DeletePost - WhiteFoo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Header-Blue.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div>
        <div class="header-blue">
            <?php include '_nav.php'; ?>
            <div class="card bg-transparent border-0 text-light">
            <?php if (!isset($_GET['PostID']) && !isset($_GET['page'])) : ?>
            <?php header('location: index.php');exit;?>
            <?php else : 
                $PostID = $_GET['PostID'];
                $page= $_GET['page'];
                DeletePost_PostID($PostID);
                if($page=='personal')
                {
                    header('location: personalpage.php');
                    exit;
                }   
                else
                {
                    header('location: index.php');
                    exit;
                }
            ?>
            <?php endif ?>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
</body>

</html>