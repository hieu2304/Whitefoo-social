<?php require_once('init.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Thông tin cá nhân - WhiteFoo</title>
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
                    <?php if (isset($_SESSION['profileID'])) : ?>
                        <article class="card-body mx-auto" style="max-width: 450px;">
                            <h4 class="card-title mt-3 text-center">Cập Nhật Thông Tin Cá Nhân</h4>
                            <form method="post" action="profile.php" enctype="multipart/form-data">
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input name="username" class="form-control" placeholder="Tên người dùng" type="name" value="<?php echo $currentUser['username'] ?>">
                                </div> <!-- form-group -->
                                
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input name="fullname" class="form-control" placeholder="Họ tên" type="name" value="<?php echo $currentUser['fullname'] ?>">
                                </div> <!-- form-group -->

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                    </div>
                                    <input name="mobilenumber" class="form-control" placeholder="Số điện thoại" type="mobilenumber" value="<?php echo $currentUser['mobilenumber'] ?>">
                                </div> <!-- form-group -->

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-upload"></i> </span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="uploadpfp" class="custom-file-input" id="customFile" accept="image/*">
                                        <label class="custom-file-label" for="customFile">Ảnh đại diện</label>
                                    </div> <!-- form-group -->
                                </div>
                                
                                <?php include('errors.php'); ?>
                                
                                <div class="form-group">
                                    <button name="update_user_profile" type="submit" class="btn btn-primary btn-block">Cập Nhật Thông Tin</button>
                                </div> <!-- form-group -->
                            </form>
                        </article>
                    <?php else : ?>
                        <p class="text-center">Bạn chưa đăng nhập, hãy <a href="login.php">Đăng Nhập</a> để xem thông tin cá nhân.</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script> <!-- form-group -->
</body>

</html>