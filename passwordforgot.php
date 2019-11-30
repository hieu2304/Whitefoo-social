<?php require_once('init.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Quên mật khẩu - WhiteFoo</title>
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
            <div class="card bg-transparent border-0 text-light">
            <?php if (!isset($_SESSION['profileID'])) : ?>
                <article class="card-body mx-auto" style="max-width: 450px;">
                    <h4 class="card-title mt-3 text-center">Quên Mật Khẩu</h4>
                    <form method="post" action="passwordforgot.php">
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                            </div>
                            <input name="email" class="form-control" placeholder="Địa chỉ Email" type="email">
                        </div> <!-- form-group -->
                        
                        <?php include('info.php'); ?>
                        <?php include('errors.php'); ?>
                        
                        <div class="form-group">
                            <button name="forgot_password" type="submit" class="btn btn-primary btn-block">Gửi Yêu Cầu Khôi Phục</button>
                        </div> <!-- form-group -->
                        <p class="text-center">Chưa có tài khoản? <a href="register.php">Đăng Ký</a> </p>
                    </form>
                </article>
            <?php else : ?>
                <p class="text-center">Bạn đã đăng nhập, hãy <a href="logout.php?logout=1">Đăng Xuất</a> để thực hiện chức năng này.</p>
            <?php endif ?>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
</body>

</html>