<?php
    require_once('init.php');
    $posts = null;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Trang cá nhân - WhiteFoo</title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/Modal.css">
</head>

<body>
    <div>
        <div class="header-blue">
            <?php include '_nav.php'; ?>
            <div id="content">
                <?php if (!isset($_SESSION['profileID'])) : ?>
                        <div class="container hero">
                            <div class="row">
                                <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
                                    <h1>ĐĂNG NHẬP ĐỂ TIẾP TỤC</h1>
                                    <button class="btn btn-light btn-lg action-button" type="button" Onclick="window.location.href='register.php'">Chưa có tài khoản? Đăng ký ngay</button></div>
                                <div
                                    class="col-md-5 col-lg-5 offset-lg-1 offset-xl-0 d-none d-lg-block phone-holder">
                                    <div class="center-img">
                                        <img src="assets\img\fox-1284512_1920.jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php else : ?>
                    <?php if (!isset($_GET['id']) || $_GET['id'] == $currentUser['profileID']) : ?>
                        <div class="container hero">
                            <div class="row">
                                <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
                                    <h1><?php echo $currentUser["username"] ?></h1>
                                    <p>Tên đầy đủ: <?php echo ($currentUser["fullname"] != "" || $currentUser["fullname"]) != null ? $currentUser["fullname"] : "Chưa có"; ?></p>
                                    <p>Số điện thoại: <?php echo ($currentUser["mobilenumber"] != "" || $currentUser["mobilenumber"]) != null ? $currentUser["mobilenumber"] : "Chưa có"; ?></p>
                                    <p>Email: <?php echo ($currentUser["email"] != "" || $currentUser["email"]) != null ? $currentUser["email"] : "Chưa có"; ?></p>
                                    <button class="btn btn-light btn-lg action-button" type="button" id="postButton">Tạo bài viết</button></div>
                                <div class="col-md-5 col-lg-5 offset-lg-1 offset-xl-1 d-none d-lg-block">
                                    <div class="center-avatar">
                                        <?php if (isset($currentUser['pfp'])): ?>
                                            <img src="profilepfp.php?id=<?php echo $currentUser['profileID']; ?>">
                                        <?php else: ?>
                                            <img src="assets\img\defaultavataruser.png">
                                        <?php endif?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="postModal" class="modal">
                            <div class="modal-content">
                                <span class="closeModal">&times;</span>
                                <form method="post" action="post.php" enctype="multipart/form-data">
                                    <div class="form-group input-group">
                                        <textarea name="content" class="form-control" placeholder="Trạng thái..." rows="5"></textarea>
                                    </div>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-upload"></i> </span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="postimg" class="custom-file-input" id="customFile" accept="image/*">
                                            <label class="custom-file-label" for="customFile">Hình ảnh</label>
                                        </div>
                                    </div>
                                                            
                                    <div class="form-group">
                                        <button name="post_the_status" type="submit" class="btn btn-primary btn-block">Đăng</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="newfeed" style="margin-top: 200px; font-family: 'Roboto', sans-serif;">
                            <?php $posts = getNewFeedsByProfileID($currentUser['profileID']); ?>
                            <div class="row" id="newfeed_content">
                                <?php foreach ($posts as $post): ?>
                                    <div class="col-sm-12">
                                        <div id="break_space_between_posts"></div>
                                        <div id="userpost" class="card" style="background-color: rgba(255, 255, 255, 0.75); border-radius: 0px; width: 70%; float: none; margin: 0 auto;">
                                            <div class="card-body">
                                            <?php if($currentUser['profileID'] == $post['profileID'] and $_SESSION['profileID'] == $post['profileID']): ?>
                                                <div class="no-class-requirement">
                                                    <button id="btn_del_post_<?php echo $post['postID']; ?>" type="button" style="float:right;background-color:transparent;font-size:20px;">
                                                        <a href= <?php echo "deletepost.php?postid=". $post['postID']."&page=main";?>  style="color:black;">X</a>
                                                    </button>                                                                                                   
                                                </div>
                                                <?php endif ?>
                                                    <div id="post_information_wrapper">
                                                        <div class="mini-avatar" id="post_information_left_child">
                                                        <?php if (isset($post["pfp"])): ?>
                                                            <img src="profilepfp.php?id=<?php echo $post['profileID'];?>">
                                                        <?php else: ?>
                                                            <img src="assets\img\defaultavataruser.png">                                  
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
                                                <?php if (!empty($post['image'])): ?>
                                                    <div id="post_img">             
                                                        <?php if (!empty($post['image'])): ?>
                                                            <div id="break_space_between_posts"></div>
                                                            <img src="postimage.php?id=<?php echo $post['postID']; ?>" class="card-img" alt="<?php echo $post['username'] ?>">
                                                        <?php endif?>
                                                    </div>
                                                <?php endif?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php $user = findUserByID($_GET['id']); ?>
                        <?php if ($user == null) : ?>
                            <div class="container hero">
                                <p class="text-center">Người dùng mà bạn đang tìm kiếm không tồn tại.</p>
                            </div>
                        <?php else : ?>
                            <div class="container hero">
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
                                        <h1><?php echo $user["username"]; ?></h1>
                                        <p>Tên đầy đủ: <?php echo ($user["fullname"] != "" || $user["fullname"]) != null ? $user["fullname"] : "Chưa có"; ?></p>
                                        <p>Số điện thoại: <?php echo ($user["mobilenumber"] != "" || $user["mobilenumber"]) != null ? $user["mobilenumber"] : "Chưa có"; ?></p>
                                        <p>Email: <a href="mailto:<?php echo $user["email"];?>" style="color:white;" ><?php echo $user["email"];?></a></p>
                                        <button class="btn btn-light btn-lg action-button" type="button" Onclick="window.location.href='post.php'">Kết bạn</button></div>
                                    <div class="col-md-5 col-lg-5 offset-lg-1 offset-xl-1 d-none d-lg-block">
                                        <div class="center-avatar">
                                            <?php if (isset($user['pfp'])): ?>
                                                <img src="profilepfp.php?id=<?php echo $user['profileID']; ?>">
                                            <?php else: ?>
                                                <img src="assets\img\defaultavataruser.png">
                                            <?php endif?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="newfeed" style="margin-top: 200px; font-family: 'Roboto', sans-serif;">
                                <?php $posts = getNewFeedsByProfileID($user['profileID']); ?>
                                <div id="newfeed_content">
                                    <?php foreach ($posts as $post): ?>
                                        <div class="col-sm-12">
                                            <div id="break_space_between_posts"></div>
                                            <div id="userpost" class="card" style="background-color: rgba(255, 255, 255, 0.75); border-radius: 0px; width: 70%; float: none; margin: 0 auto;">
                                                <div class="card-body">
                                                        <div id="post_information_wrapper">
                                                            <div class="mini-avatar" id="post_information_left_child">
                                                            <?php if (isset($post["pfp"])): ?>
                                                                <img src="profilepfp.php?id=<?php echo $post['profileID'];?>">
                                                            <?php else: ?>
                                                                <img src="assets\img\defaultavataruser.png">                                  
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
                                                    <?php if (!empty($post['image'])): ?>
                                                        <div id="post_img">             
                                                            <?php if (!empty($post['image'])): ?>
                                                                <div id="break_space_between_posts"></div>
                                                                <img src="postimage.php?id=<?php echo $post['postID']; ?>" class="card-img" alt="<?php echo $post['username'] ?>">
                                                            <?php endif?>
                                                        </div>
                                                    <?php endif?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
    <script src="assets/js/modal.js"></script>
    <script src="assets/js/content.js"></script>
    <script>
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>

</html>