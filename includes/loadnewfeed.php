<?php
    require_once("../init.php");
    require_once("../func.php");
    $Parsedown = new Parsedown();
    $Parsedown->setBreaksEnabled(true);
    $Parsedown->setMarkupEscaped(true);

    $pagenum = $_POST['start'];
    $postlimit = $_POST['limit'];
    $typeofpage = $_POST['page'];
    $profileID = $_POST['profileID'];
    $privacy = getPrivacy();
    if($typeofpage == 'main'):
        $posts = getVisibleNewFeedsPaginate($currentUser['profileID'], $pagenum, $postlimit);
    else:
        if($profileID == -1):
            $posts = getNewFeedsByProfileIDPaginate($currentUser['profileID'], $pagenum, $postlimit);
        else:
            if ($profileID == $currentUser['profileID']):
                $posts = getNewFeedsByProfileIDPaginate($currentUser['profileID'], $pagenum, $postlimit);
            elseif (isFriend($profileID, $currentUser['profileID'])):
                $posts = getFriendNewFeedsByFriendIDPaginate($profileID, $pagenum, $postlimit);
            else:
                $posts = getPublicNewFeedsByProfileIDPaginate($profileID, $pagenum, $postlimit);
            endif;
        endif;
    endif;
    $temp = 0;
    foreach ($posts as $post) :
    	if($temp == 0):
?>
    	<script src="assets/js/modifypost.js"></script>
    	<?php $temp=1; endif;
?>

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
                                    <button class="set-visibility dropdown-item" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-lock"></i> Thay đổi quyền riêng tư</button>
                                    <div postid="<?php echo $post['postID']; ?>" class="visibility-picker dropdown-menu">
                                        <?php foreach ($privacy as $visibility) : ?>
                                            <button class="dropdown-item" type="button" name="setprivacy" value="<?php echo $visibility["id"] ?>"><?php echo $visibility["visibility"] ?></button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <?php endif;?>
                    <div id="post_information_wrapper">
                        <div class="mini-avatar" id="post_information_left_child">
                            <?php if (isset($post["pfp"])): ?>
                                <img class="lazyload" data-src="profilepfp.php?id=<?php echo $post['profileID'];?>&width=720&height=720" src="profilepfp.php?id=<?php echo $post['profileID'];?>&placeholder">
                            <?php else: ?>
                                <img class="lazyload" data-src="assets/img/defaultavataruser.png">                                  
                            <?php endif?>
                        </div>      
                        <div id="post_information_center_child">
                        <div id="break_space_between_posts"></div>
                            <h5 class="card-title">
                                <a href="personalpage.php?id=<?php echo $post["profileID"] ?>"><strong><?php echo ($post["fullname"] != "" || $post["fullname"]) != null ? $post["fullname"] : $post["username"] ?></strong></a>                                                                     
                            </h5>
                            <p class="card-info">
                                <small class="card-subtitle mb-2 text-muted">
                                    <i value="<?php echo $post['postID']; ?>" class="post-visibility <?php echo $post["visibility"] == 0 ? "fa fa-globe" : ($post["visibility"] == 1 ? "fas fa-user-friends" : "fa fa-lock") ?>"></i>
                                    <i class="fa fa-calendar"></i> <?php echo $post['createdAt'];?>
                                </small>
                            </p>  
                        </div>                                                                                                        
                    </div>
                    <?php if (isset($post['content'])) : ?>
                        <div class="card-text" id="post_content">
                            <p value="<?php echo $post['postID'] . '-postcontent'; ?>" class="card-text" style="width: 90%;"><?php echo $Parsedown->text($post['content']);?></p>
                        </div>
                    <?php endif; ?>
                    <div id="post_img">             
                        <?php if (!empty($post['image'])): ?>
                            <div id="break_space_between_posts"></div>
                            <img value="<?php echo $post['postID'] . '-postimg'; ?>" class="lazyload blur-up" data-src="postimage.php?id=<?php echo $post['postID']; ?>&width=720&height=720" src="postimage.php?id=<?php echo $post['postID']; ?>&placeholder" class="card-img" alt="<?php echo $post['username'] ?>">
                        <?php endif?>
                    </div>
                </div>
                <div class="post-action-wrapper">
                    <div class="post-three-action">
                        <button value="<?php echo $post['postID'] . '-likebtn'; ?>" class="btn-action-like"><i class="fa fa-thumbs-up" style="font-weight: bold;"></i> Thích</button>
                    </div>
                    <div class="post-three-action">
                        <button value="<?php echo $post['postID'] . '-commentbtn'; ?>" class="btn-action-comment"><i class="fa fa-comment" style="font-weight: bold;"></i> Bình Luận</button>
                    </div>
                    <div class="post-three-action">
                        <button value="<?php echo $post['postID'] . '-sharebtn'; ?>" class="btn-action-share"><i class="fa fa-reply" style="font-weight: bold;"></i> Chia sẻ</button>
                    </div>
                </div>
                <div id="break_space_between_posts"></div>
            </div>
        </div>
<?php endforeach ?>