<?php require_once('init.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="assets/css/Header-Blue.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="assets/js/searching-approximately.js"></script>
        <script type="text/javascript" src="assets/js/lazysizes.min.js" async=""></script>
    </head>
    <body>
        <nav class="navbar navbar-light navbar-expand-md">
            <div class="container-fluid">
                <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Menu</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li class="nav-item" role="presentation"><h4><a class="nav-link" href="index.php"><i class="fa fa-home"></i> Trang chủ</i></a></h4></li>
                    </ul>
                    <!-- Logged in user information -->
                    <?php if (isset($_SESSION['profileID'])) : ?>
                        <?php $users = getUserList($_SESSION['profileID']); ?>
                    <ul class="nav navbar-nav">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="personalpage.php">Trang cá nhân</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="messenger-recent.php">Tin nhắn</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="friend-list.php">Danh sách bạn bè</a></li>
                    </ul>
                    <form class="form-inline mr-auto" target="_self">
                            <div class="form-group" style="position: relative;">
                                <label for="search-field"><i class="fa fa-search"></i></label>
                                <input id="myInput1" onkeyup="SearchingFunc1()" class="form-control search-field" type="text" placeholder= "Tìm kiếm người dùng..." name="search">
                                <ul id="myUL1" value="Danh sách user" style="position: absolute; top: 40px; padding-left: 15px;">
                                    <?php foreach ($users as $user) : ?>
                                      <div class="user-wrapper" id="warpuser">                                                                              
                                        <li>
                                            <div>
                                              <a href="personalpage.php?id=<?php echo $user["profileID"] ?>" style="display: flex; margin-bottom: 10px;text-decoration: none;">
                                                <div class="component-pic" value="profilePic" style="margin-right: 10px;">
                                                    <?php if (isset($user["pfp"])): ?>
                                                        <img style="width:30px; margin: 5px 0 0 10px;" class="lazyload" data-src="profilepfp.php?id=<?php echo $user['profileID'];?>">
                                                    <?php else: ?>
                                                        <img style="width:30px; margin: 5px 0 0 10px;" class="lazyload" data-src="assets/img/defaultavataruser.png">                                  
                                                    <?php endif?>
                                                </div>
                                                <div class="component-name" value ="tên">
                                                    <div class="userName" id="userName" style="padding-top: 10px;"><?php echo ($user["fullname"] != "" || $user["fullname"]) != null ? $user["fullname"] : $user["username"] ?></div>
                                                </div>                                      
                                               </a>
                                            </div>                                  
                                        </li>
                                    </div>

                                    <?php endforeach; ?>    
                                </ul>

                            </div>
                    </form>
                    <div class="navbar navbar-light navbar-expand-md" id="options">
                        <div class="nav navbar-nav">
                            <div class="nav-item dropdown">
                            <button class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" id="dropbtn-option">Tùy chọn</button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu" id="dropdown-content">
                                <div><a class="dropdown-item" role="presentation" id="drop-info-item" href="profile.php">Thay đổi thông tin <br>(<?php echo $currentUser['username']; ?>)</a></div>
                                <div><a class="dropdown-item" role="presentation" id="drop-info-item" href="password.php">Đổi mật khẩu</a></div>
                                <div><a class="dropdown-item" role="presentation" id="drop-info-item" href="post.php">Tạo bài viết</a></div>
                                <div><a class="dropdown-item" role="presentation" id="drop-info-item" href="logout.php?logout=1">Đăng xuất</a></div>
                            </div>
                        </div>
                    </div>
                    </div>      
                    <?php else : ?>
                        <!-- Login and Register -->
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item"><span class="navbar-text"> <a class="login" href="login.php">Đăng nhập</a></span></li>
                        <li class="nav-item"><a class="btn btn-light action-button" role="button" href="register.php">Đăng ký</a></li>
                    </ul>
                    <?php endif ?>
                </div>
            </div>
        </nav>
    </body>
</html>