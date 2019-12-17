<?php require_once('init.php');
 ob_start();?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Comments - WhiteFoo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Header-Blue.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div id="Kk" style="height:400px;width:730px;float:left; margin-left: 20px;overflow:auto">
                        <form method ="post" endtype="multipart/formdata"> <textarea row="5" cols="50" name="txt1" id="txt1">
                         </textarea>
                        <div class="form-group">
                        <input type="hidden" name="comment_id" id="comment_id" value="0" />
                        <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
                    </div>
                     <?php
                    if(isset($_POST["submit"]))
                    {
                             if (isset($_SESSION['profileID']) and $_SESSION['profileID'] == $currentUser['profileID']) :
                                $PostID = $_GET['postID'];
                                $ProfileId = $_SESSION['profileID'];
                                // $pagenum = $_POST['start'];
                                // $postlimit = $_POST['limit'];
                                $var = $_POST["txt1"];
                                global $db;
                                $stmt = $db->prepare("INSERT INTO comments (comment,profileID,postID) VALUE(?,?,?)");
                                $stmt->execute([$var,$_SESSION['profileID'],$PostID]);
                                 $posts = getNewCommentsByProfileIDPaginate($_SESSION['profileID'],0 ,2);
                            else:
                                header('location: logout.php');
                                exit;
                    endif;
                    }
                     foreach ($posts as $post) :
                      ?>
                     <div id="post_information_wrapper">
                                 <div class="mini-avatar" id="post_information_left_child">
                                     <?php if (isset($currentUser["pfp"])): ?>
                                        <img class="lazy" data-src="profilepfp.php?id=<?php echo $currentUser['profileID'];?>">
                                     <?php else: ?>
                                         <img class="lazy" data-src="assets/img/defaultavataruser.png">
                                     <?php endif?>
                                 </div>
                                 <div id="post_information_center_child">
                                     <div id="break_space_between_posts"></div>
                                         <h5 class="card-title">
                                             <a href="personalpage.php?id=<?php echo $ProfileId ?>"><strong><?php echo $currentUser['username'] ?></strong></a>
                                         </h5>
                                     </div>
                                 </div>
                                 <div id="post_content">
                                     <p value="<?php echo $var . '-cmtcontent'; ?>" class="card-text" style="width: 90%;"><?php echo $var;?></p>
                                 </div>
                     </div>
                     <?php endforeach ?>
                    </div>                                                            
</body>
