<?php
    require_once("../init.php");
    require_once("../func.php");
    $pagenum = $_POST['start'];
    $postlimit = $_POST['limit'];
    $typeofpage = $_POST['page'];
    $profileID = $_POST['profileID'];
    //the 'include script' moved to <head>
    if($typeofpage == 'main'):
        $posts = getNewFeedsPaginate($pagenum, $postlimit);
    else:
        if($profileID == -1):
            $posts = getNewFeedsByProfileIDPaginate($_SESSION['profileID'], $pagenum, $postlimit);
        else:
            $posts = getNewFeedsByProfileIDPaginate($profileID, $pagenum, $postlimit);
        endif;
    endif;
    foreach ($posts as $post) :
?>
<head><script src="assets/js/modifypost.js"></script></head>
        <div class="col-sm-12">
            <div value="<?php echo 'userpost-'.$post['postID']; ?>" id="userpost" class="card" style="background-color: rgba(255, 255, 255, 0.75); border-radius: 0px; width: 70%; float: none; margin: 0 auto; margin-bottom:10px;">
                <div class="card-body">
                    <?php if($currentUser['profileID'] == $post['profileID'] and $_SESSION['profileID'] == $post['profileID']): ?>
                    <div class="navbar navbar-light navbar-expand-md navigation-clean-search" style="float:right; padding: 0% 0% 0% 0%;">
                        <ul class="nav navbar-nav">
                            <li class="nav-item dropdown">
                                <button class="caret-off" class="dropdown-toggle nav-link" id="post-dropbtn" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu" id="post-dropdown-content">
                                    <button value="<?php echo $post['postID'] . '-deletebtn'; ?>" class="dropdown-item" role="presentation" onclick="getbuttonvalue(this)"><i class="fa fa-trash-o"></i> Xóa bài viết</button>
                                    <!-- <button class="dropdown-item" role="presentation" href="<?php echo "deletepost.php?postid=". $post['postID']."&page=main";?>"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa bài viết</button> -->
                                </div>
                            </li>
                        </ul>
                    </div>
                    <?php endif;?>
                    <div id="post_information_wrapper">
                        <div class="mini-avatar" id="post_information_left_child">
                            <?php if (isset($post["pfp"])): ?>
                                <img class="lazy" data-src="profilepfp.php?id=<?php echo $post['profileID'];?>">
                            <?php else: ?>
                                <img class="lazy" data-src="assets/img/defaultavataruser.png">                                  
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
                        <p value="<?php echo $post['postID'] . '-postcontent'; ?>" class="card-text" style="width: 90%;"><?php echo $post['content'];?></p>
                    </div>                                       
                    <div id="post_img">             
                        <?php if (!empty($post['image'])): ?>
                            <div id="break_space_between_posts"></div>
                            <img value="<?php echo $post['postID'] . '-postimg'; ?>" class="lazy" data-src="postimage.php?id=<?php echo $post['postID']; ?>" class="card-img" alt="<?php echo $post['username'] ?>">
                        <?php endif?>
                    </div>
                </div>                
                <div class="post-action-wrapper">
                    <div class="post-three-action" >
                    <a href="#.php" class="">
                        <button value="<?php echo $post['postID'] . '-likebtn'; ?>" class="btn-action-like"><i class="fa fa-thumbs-up" style="font-weight: bold;"></i> Thích</button>
                    </a>
                    </div>
                    <div class="post-three-action">
                    <a href="#.php" class="">
                        <button value="<?php echo $post['postID'] . '-commentbtn'; ?>" class="btn-action-comment"><i class="fa fa-comment" style="font-weight: bold;"></i> Bình Luận</button>
                    </a>
                    </div>
                    <div class="post-three-action">
                    <a href="#.php" class=""> 
                        <button value="<?php echo $post['postID'] . '-sharebtn'; ?>" class="btn-action-share"><i class="fa fa-reply" style="font-weight: bold;"></i> Chia sẻ</button>
                    </a>
                    </div>
                </div>
                <div id="break_space_between_posts"></div>
            </div>
        </div>
<?php endforeach ?>