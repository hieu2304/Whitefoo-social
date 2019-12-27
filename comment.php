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
    <title>Comment bài viết - WhiteFoo</title>
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
            <div class ="card-body"style="background-color: rgba(255,255,255,0.75);width:70%; margin-left: 200px;"> 
                <div  id="post_information_wrapper">
                    <div class="mini-avatar" id="post_information_left_child">
                        <?php if (isset($post["pfp"])): ?>
                            <img class="lazyload" data-src="profilepfp.php?id=<?php echo $post['profileID'];?>&width=450&height=450" src="profilepfp.php?id=<?php echo $post['profileID'];?>&placeholder">
                        <?php else: ?>
                            <img class="lazyload" data-src="assets/img/defaultavataruser.png">                                  
                        <?php endif?>
                    </div>
                    <div id="post_information_center_child">
                    <div id="break_space_between_posts"></div>
                        <div class="card-text" id="post_content">
                            <p style="text-align: left; margin: 30px;font-size: 30px;" class="card-text" style="width: 90%;"><?php echo $post['content'];?></p>
                    </div>
                    </div>
                </div>
                <div id="break_space_between_posts"></div>
                <div id="content">
                    <form method ="post" endtype="multipart/formdata">                   
                    <textarea  style="width: 100%; margin-left:0%; min-width:200px;"name="txt1" id="txt1"></textarea>
                        <div class="form-group">                       
                            <input type="hidden" name="comment_id" id="comment_id" value="0" />
                            <button style="margin-left:91%;" type="submit" name="submit" id="submit" class="btn btn-info" value="submit" ><i class="fa fa-comment" style="font-weight: bold;"></i>  Đăng</button>
                        </div>
                        <?php
                            if (!isset($_GET['postID']) && !isset($_GET['profileID'])) :
                                header('location: index.php');
                                exit;
                            else :
                                {if(isset($_POST["submit"]))                         
                                    if (isset($_SESSION['profileID']) and $_SESSION['profileID'] == $currentUser['profileID']) :                                                    
                                        $PostID = $_GET['postID'];                                      
                                        $ProfileId = $_SESSION['profileID'];
                                        $var = $_POST["txt1"];
                                        global $db;
                                        $stmt = $db->prepare("INSERT INTO comments (comment,profileIDcmt,postID) VALUE(?,?,?)");
                                        $stmt->execute([$var,$_SESSION['profileID'],$PostID]);
                                    else:
                                        header('location: index.php');
                                        exit;
                                endif;}
                            endif ?>
                        <div id="break_space_between_posts"></div>      
                        <div style="display: block;"id="area_commt_<?php echo  $post['postID'];?>">
                            <div  id="post_information_wrapper"> 
                                <?php $comments = getAllComment($post['postID']);?>
                                <?php foreach($comments as $comment): ?>                                   
                                    <div style="background-color:white"  id="post_information_wrapper">
                                         <div class="mini-avatarcmt" id="post_information_left_child"style="width:50px;height:70px;margin-left:15px;margin-top:10px">
                                             <?php if (isset($comment["pfp"])): ?>
                                                <img class="lazyload" data-src="profilepfp.php?id=<?php echo $comment['profileID'];?>&width=450&height=450" src="profilepfp.php?id=<?php echo $comment['profileID'];?>&placeholder">
                                            <?php else: ?>
                                                <img class="lazyload" data-src="assets/img/defaultavataruser.png">                                  
                                            <?php endif?>
                                        <div style="margin-left:4px;font-weight: bold;color:rgb(100, 149, 237);"  id="show-cmt">
                                            <?php echo $comment["username"];?>
                                        </div>    
                                    </div>                                    
                                    <div id="post_information_center_child">
                                        <div class="card-text" id="post_content">
                                            <p style="margin-top: 30px;margin-left:15px" class="card-text" style="width: 90%;"><?php echo $comment['comment'];?></p>
                                        </div>                                      
                                    </div>
                                    </div>
                                                      
                            </div>                               
                                <?php endforeach; ?>                                                       
                        </div>                         
                </div>            
            </div>
        </div>    
    </div>
    <?php include '_footer.php'; ?>
</body>
</html>