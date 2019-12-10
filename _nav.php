<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="assets/css/Header-Blue.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="assets/js/jquery.lazy/jquery.lazy.min.js"></script>
         <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
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
                    <ul class="nav navbar-nav">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="personalpage.php">Trang cá nhân</a></li>
                    </ul>                       
                    <ul class="nav navbar-nav">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="post.php">Tạo bài viết</a></li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="password.php">Đổi mật khẩu</a></li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="profile.php">Thay đổi thông tin (<?php echo $currentUser['username']; ?>)</a></li>
                    </ul>
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item"><span class="navbar-text"> <a class="login" href="logout.php?logout=1">Đăng xuất</a></li>
                    </ul>
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