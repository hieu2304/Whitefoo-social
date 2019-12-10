<?php require_once('init.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Xác thực tài khoản - WhiteFoo</title>
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
                            <h4 class="card-title mt-3 text-center">Xác Thực Tài Khoản</h4>
                            <?php if (!isset($_GET['code'])) : ?>
                                <form method="get" action="verifyuser.php">
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-key"></i> </span>
                                        </div>
                                        <input name="code" class="form-control" placeholder="Mã xác thực" type="code">
                                    </div> <!-- form-group -->
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Xác Nhận</button>
                                    </div> <!-- form-group -->
                                </form>
                            <?php else : ?>
                                <?php
                                    //VERIFY CODE
                                    $code = $_GET['code'];
                                    $success = false;
                                    $success = activateUser($code);
                                ?>
                                <?php if ($success): ?>
                                    <div class="alert alert-success" role="alert">
                                        Kích hoạt tài khoản thành công! <a href="login.php">Đăng nhập</a>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-danger" role="alert">
                                        Kích hoạt tài khoản thất bại!
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