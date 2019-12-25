<?php 
        require_once('init.php');
        ob_start();
        $post =findPostByID($_GET['postID']);
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
            <div id="post_information_wrapper">
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
                                <p class="card-text" style="width: 90%;"><?php echo $post['content'];?></p>
                           </dv>                                      
                        </div>
            </div>                        
            <div id="break_space_between_posts"></div>    
            <div id="content">
                 <form method ="post" endtype="multipart/formdata">                   
                <textarea  row="5" cols="50" name="txt1" id="txt1"></textarea>
                    <div class="form-group">                       
                        <input type="hidden" name="comment_id" id="comment_id" value="0" />
                        <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
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
                                        $stmt = $db->prepare("INSERT INTO comments (comment,profileID,postID) VALUE(?,?,?)");
                                        $stmt->execute([$var,$_SESSION['profileID'],$PostID]);
                                    else:
                                        header('location: index.php');
                                        exit;
                            endif;}
                        endif ?>                    
            </div>            
        </div>
    </div>
    <?php include '_footer.php'; ?>
</body>
</html>