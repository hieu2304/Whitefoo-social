<?php
    require_once("../init.php");
    require_once("../func.php");
    $pagenum = $_POST['start'];
    $postlimit = $_POST['limit'];
    $posts = getNewFeedsPaginate($pagenum, $postlimit);
    foreach ($posts as $post) :
?>
        <div class="col-sm-12">
            <div id="break_space_between_posts"></div>
            <div id="userpost" class="card" style="background-color: rgba(255, 255, 255, 0.75); border-radius: 0px; width: 70%; float: none; margin: 0 auto;">
                <div class="card-body">
                    <?php if($currentUser['profileID'] == $post['profileID'] and $_SESSION['profileID'] == $post['profileID']): ?>
                    <div class="no-class-requirement">
                        <button id="btn_del_post_<?php echo $post['postID']; ?>" type="button" style="float:right; background-color:transparent; font-size:20px;">
                            <a href=<?php echo "deletepost.php?postid=". $post['postID']."&page=main";?>  style="color:black;">X</a>
                        </button>                                                                                                   
                    </div>
                    <?php endif?>
                    <div id="post_information_wrapper">
                        <div class="mini-avatar" id="post_information_left_child">
                            <?php if (isset($post["pfp"])): ?>
                                <img class="lazy" data-src="profilepfp.php?id=<?php echo $post['profileID'];?>">
                            <?php else: ?>
                                <img class="lazy" data-src="assets/img/defaultavataruser.png">                                  
                            <?php endif?>
                        </div>      
                        <div id="post_information_center_child">
                            <?php echo "<br>";?>
                            <h5 class="card-title">
                                <a href="personalpage.php?id=<?php echo $post["profileID"] ?>"><strong><?php echo ($post["fullname"] != "" || $post["fullname"]) != null ? $post["fullname"] : $post["username"] ?></strong></a>                                                                     
                            </h5>
                            <p class="card-text">&nbsp<small class="card-subtitle mb-2 text-muted"><?php echo $post['createdAt'];?></small></p>  
                        </div>                                                                                                        
                    </div>
                    <div id="post_content">                              
                        <p class="card-text" style="width: 90%;"><?php echo $post['content'];?></p>
                    </div>                                       
                    <div id="post_img">             
                        <?php if (!empty($post['image'])): ?>
                            <div id="break_space_between_posts"></div>
                            <img class="lazy" data-src="postimage.php?id=<?php echo $post['postID']; ?>" class="card-img" alt="<?php echo $post['username'] ?>">
                        <?php endif?>
                    </div>
                </div>
            </div>
        </div>
<?php endforeach ?>