<?php 
    require_once('init.php');
    ob_start();
    $post = findPostByID($_GET['postID']);
    if ($post == null)
    {
        echo "Bài viết không khả dụng.";
        exit;
    }
    elseif ($post["visibility"] == 1)
    {
        if ($currentUser["profileID"] != $post["profileID"])
        {
            if (isFriend($currentUser["profileID"], $post["profileID"]) == false)
            {
                echo "Bài viết không khả dụng.";
                exit;
            }
        }
    }
    elseif ($post["visibility"] == 2)
    {
        if($currentUser["profileID"] != $post["profileID"])
        {
            echo "Bài viết không khả dụng";
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Like bài viết - WhiteFoo</title>
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
            <div id="content">
                <div class="card bg-transparent border-0 text-light">
                    <?php               
                        if (!isset($_GET['postID']) && !isset($_GET['profileID'])) :
                            header('location: index.php');
                            exit;
                        else :                           
                            if (isset($_SESSION['profileID']) and $_SESSION['profileID'] == $currentUser['profileID'] and $post['visibility'] != 2) :                     
                                $PostID = $_GET['postID'];                                     
                                $ProfileId = $_GET['profileID'];
                                if($PostID ==$post['postID']):
                                    deleteLike_By_profileID_postID($_SESSION['profileID'],$PostID);
                                    header('location: index.php');
                                else:
                                    insertLike_By_profileID_postID($_SESSION['profileID'],$PostID);
                                    header('location: index.php');
                                    exit;
                                endif;
                            else:
                                header('location: index.php');
                                exit;
                            endif;
                        endif ?>                    
                </div>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
</body>
</html>