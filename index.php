<?php
    require_once('init.php');
    $posts = getNewFeeds();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>WhiteFoo</title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div>
        <div class="header-blue">
            <?php include '_nav.php'; ?>
            <!-- nếu người dùng chưa đăng nhập -->
            <?php if (!isset($_SESSION['profileID'])) : ?>
                <div class="container hero">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
                            <h1>ĐĂNG KÝ NGAY</h1>
                            <button class="btn btn-light btn-lg action-button" type="button" Onclick="window.location.href='register.php'">Đăng Ký Ngay</button></div>
                        <div class="col-md-5 col-lg-5 offset-lg-1 offset-xl-0 d-none d-lg-block phone-holder">
                            <div class="center-img">
                                <img src="assets\img\fox-1284512_1920.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            <!-- nếu người dùng đã đăng nhập -->   
            <?php else : ?>
            <!-- hiện thông tin tóm tắt của người dùng -->
                <div class="container hero">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
                            <h1>Xin chào, <?php echo ($currentUser["fullname"] != "" || $currentUser["fullname"]) != null ? $currentUser["fullname"] : $currentUser["username"] ?></h1>
                            <button class="btn btn-light btn-lg action-button" type="button" onClick="document.getElementById('newfeed').scrollIntoView();">Xem các bài viết</button></div>
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
                <!-- newfeeds -->
                <div class="row" id="newfeed" style="margin-top: 200px; font-family: 'Roboto', sans-serif;">
                <!-- vòng lập in newfeeds được lấy từ trước, posts là 1 mảng được trả ra từ hàm -->
                    <?php foreach ($posts as $post): ?>
                        <div class="col-sm-12">
                            <!-- khung mỗi bài đăng -->
                            <div id="break_space_between_posts"></div>
                            <div class="card" style="background-color: rgba(255, 255, 255, 0.75); border-radius: 0px; width: 60%; float: none; margin: 0 auto;">
                                <div class="card-body">
                                    <!-- in thông tin người đăng -->
                                        <!-- in ảnh người đăng nằm bên trái của tên người này -->
                                        <!-- nếu người này có ảnh đại diện thì hiển thị ra, nếu không có thì hiển thị ảnh mặc định -->
                                        <div class="mini-avatar" id="post_information_wrapper">
                                            <div id="post_information_left_child">
                                            <?php if (CheckAvatarIsNullByUserID($post['profileID'])==1): ?>
                                                <img src="profilepfp.php?id= <?php echo $post['profileID'];?>" style="">
                                            <?php else: ?>
                                                <img src="assets\img\defaultavataruser.png" style="">                                  
                                            <?php endif?>
                                            </div>      
                                             <!-- in tên và thời gian người đăng nằm bên phải so với hình ảnh người này -->
                                             <div id="post_information_center_child">
                                                 <?php echo "<br>";?>
                                            <!-- in ra tên người đăng -->
                                                <h5 class="card-title">
                                                    <a href="personalpage.php?id=<?php echo $post["profileID"] ?>"><strong><?php echo ($post["fullname"] != "" || $post["fullname"]) != null ? $post["fullname"] : $post["username"] ?></strong></a>                                                                     
                                                </h5>
                                                 <!-- in ra thời gian đăng bài này -->
                                                 <p class="card-text">&nbsp&nbsp<small class="card-subtitle mb-2 text-muted"><?php echo $post['createdAt'];?></small></p>
                                            </div>
                                        </div>                                      
                                    <!-- in ra nội dung cho mỗi post -->            
                                    <p class="card-text"><?php echo $post['content'];?></p>
                                    
                                    <!-- nếu post có ảnh đính kèm, in ảnh đính kèm -->
                                    <?php if (!empty($post['image'])): ?>
                                        <img src="postimage.php?id=<?php echo $post['postID']; ?>" class="card-img" alt="..." style="width: 250px;">
                                    <?php endif?>
                                </div>
                            </div>
                        </div>
                        <!-- kết thúc vòng lập lấy bài đăng newfeeds -->
                    <?php endforeach ?>
                </div>
                <!-- kết thúc cái if Người dùng đã đăng nhập/không đăng nhập -->
            <?php endif ?> 
        </div>
    </div>
    <?php include '_footer.php'; ?>
</body>

</html>