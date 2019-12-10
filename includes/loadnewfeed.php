<?php
    require_once("../init.php");
    require_once("../func.php");
    $pagenum = $_POST['start'];
    $postlimit = $_POST['limit'];
    $posts = getNewFeedsPaginate($pagenum, $postlimit);
    foreach ($posts as $post) :
?>
        <div class="col-sm-12">
            <div id="userpost" class="card" style="background-color: rgba(255, 255, 255, 0.75); border-radius: 0px; width: 70%; float: none; margin: 0 auto; margin-bottom:10px;">
                <div class="card-body">
                    <?php if($currentUser['profileID'] == $post['profileID'] and $_SESSION['profileID'] == $post['profileID']): ?>
                    <div class="post-dropdown">
                    <button class="post-dropbtn"><i class="fa fa-chevron-down"></i></button>
                        <div class="post-dropdown-content">
                            <a href="<?php echo "deletepost.php?postid=". $post['postID']."&page=main";?>"><i class="fa fa-trash-o"></i> Xóa bài viết</a>
                            <a href="#"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa bài viết</a>
                            <a href="#"><i class="fa fa-ban"></i> Tắt bình luận</a>
                        </div>                                                                                                                    
                    </div>
                    <?php else:?>
                    <div class="post-dropdown">
                    <button class="post-dropbtn"><i class="fa fa-chevron-down"></i></button>
                        <div class="post-dropdown-content">
                            <a href="#"><i class="fa fa-exclamation-circle"></i> Báo cáo bài viết này</a>
                        </div>                                                                                                                    
                    </div>
                    <?php endif;?>
                    <div id="post_information_wrapper">
                        <div class="mini-avatar" id="post_information_left_child">
                            <?php if (isset($post["pfp"])): ?>
                                <img class="lazy" src="profilepfp.php?id=<?php echo $post['profileID'];?>">
                            <?php else: ?>
                                <img class="lazy" src="assets/img/defaultavataruser.png">                                  
                            <?php endif?>
                        </div>      
                        <div id="post_information_center_child">
                        <div id="break_space_between_posts"></div>
                            <h5 class="card-title">
                                <a href="personalpage.php?id=<?php echo $post["profileID"] ?>"><strong><?php echo ($post["fullname"] != "" || $post["fullname"]) != null ? $post["fullname"] : $post["username"] ?></strong></a>                                                                     
                            </h5>
                            <p class="card-text"><small class="card-subtitle mb-2 text-muted"><i class="fa fa-calendar"></i> <?php echo $post['createdAt'];?></small></p>  
                        </div>                                                                                                        
                    </div>
                    <div id="post_content">                              
                        <p class="card-text" style="width: 90%;"><?php echo $post['content'];?></p>
                    </div>                                       
                    <div id="post_img">             
                        <?php if (!empty($post['image'])): ?>
                            <div id="break_space_between_posts"></div>
                            <img class="lazy" src="postimage.php?id=<?php echo $post['postID']; ?>" class="card-img" alt="<?php echo $post['username'] ?>">
                        <?php endif?>
                    </div>
                </div>
                <div class="post-action-wrapper">
                    <div class="post-three-action">
                        <button class="btn-action-like"><i class="fa fa-thumbs-up" style="font-weight: bold;"></i> Thích</button>
                    </div>
                    <div class="post-three-action">
                        <button class="btn-action-comment"><i class="fa fa-comment" style="font-weight: bold;"></i> Bình Luận</button>
                    </div>
                    <div class="post-three-action">
                        <button class="btn-action-share"><i class="fa fa-reply" style="font-weight: bold;"></i> Chia sẻ</button>
                    </div>
                </div>
                <div id="break_space_between_posts"></div>
            </div>
        </div>
<?php endforeach ?>