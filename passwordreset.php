<?php require_once('init.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Đặt lại mật khẩu - WhiteFoo</title>
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
                        <article class="card-body mx-auto" style="max-width: 450px;">
                            <h4 class="card-title mt-3 text-center">Đặt Lại Mật Khẩu</h4>
                            <?php if (!isset($_GET['code'])) : ?>
                                <form method="get" action="passwordreset.php">
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-key"></i> </span>
                                        </div>
                                        <input name="code" class="form-control" placeholder="Mã xác nhận" type="code">
                                    </div> <!-- form-group -->
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Xác Nhận</button>
                                    </div> <!-- form-group -->
                                </form>
                            <?php else : ?>
                                <?php
                                    //VERIFY RESET PASSWORD CODE
                                    $code = $_GET['code'];
                                    $profileID = verifyResetPassword($code);
                                    $_SESSION['resetPasswordID'] = $profileID;
                                ?>
                                <?php if ($profileID > 0): ?>
                                    <form method="post" action="passwordreset.php?code=<?php echo $code; ?>">
                                        <div class="form-group input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                            </div>
                                            <input name="password" class="form-control" placeholder="Mật khẩu mới" type="password">
                                        </div> <!-- form-group -->

                                        <div class="form-group input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                            </div>
                                            <input name="password_retype" class="form-control" placeholder="Xác nhận mật khẩu mới" type="password">
                                        </div> <!-- form-group -->
                                        
                                        <?php include('errors.php'); ?>
                                        
                                        <div class="form-group">
                                            <button name="reset_user_password" type="submit" class="btn btn-primary btn-block">Đổi Mật Khẩu</button>
                                        </div> <!-- form-group -->
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-danger" role="alert">
                                        Mã xác nhận không hợp lệ! <a href="passwordreset.php">Thử lại</a>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                        </article>
                    <?php else : ?>
                        <p class="text-center">Bạn đã đăng nhập, hãy <a href="logout.php?logout=1">Đăng Xuất</a> để thực hiện chức năng này.</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
</body>

</html>