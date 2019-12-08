<?php require_once('init.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Đăng ký - WhiteFoo</title>
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
            <div id="content">
                <div class="card bg-transparent border-0 text-light">
                    <?php if (!isset($_SESSION['profileID'])) : ?>
                        <article class="card-body mx-auto" style="max-width: 400px;">
                            <h4 class="card-title mt-3 text-center">Đăng Ký</h4>
                            <form method="post" action="register.php">
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input name="username" class="form-control" placeholder="Tên người dùng" type="text">
                                </div> <!-- form-group -->
                                
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                    </div>
                                    <input name="email" class="form-control" placeholder="Địa chỉ Email" type="email">
                                </div> <!-- form-group -->
                                
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="password" class="form-control" placeholder="Mật khẩu" type="password">
                                </div> <!-- form-group -->
                                
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="password_retype" class="form-control" placeholder="Nhập lại mật khẩu" type="password">
                                </div> <!-- form-group --> 
                                
                                <!-- Thông tin đăng ký -->
                                <?php include('info.php'); ?>
                                <!-- Lỗi đăng ký -->
                                <?php include('errors.php'); ?>
                                
                                <div class="form-group">
                                    <button name="register_new" type="submit" class="btn btn-primary btn-block">Đăng Ký</button>
                                </div> <!-- form-group -->      
                                <p class="text-center">Đã có tài khoản? <a href="login.php">Đăng Nhập</a> </p>
                            </form>
                        </article>
                    <?php else : ?>
                        <p class="text-center">Bạn đã đăng nhập, hãy <a href="logout.php?logout=1">Đăng Xuất</a> để có thể đăng ký.</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
</body>
</html>