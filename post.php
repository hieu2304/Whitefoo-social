<?php require_once('init.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Đăng bài viết - WhiteFoo</title>
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
            <?php if (isset($_SESSION['profileID'])) : ?>
                <article class="card-body mx-auto" style="width: 50%; max-width: 850px;">
                    <h4 class="card-title mt-3 text-center">Đăng Trạng Thái</h4>
                    <form method="post" action="post.php" enctype="multipart/form-data">
                        <div class="form-group input-group">
                            <textarea name="content" class="form-control" placeholder="Trạng thái..." rows="5"></textarea>
                        </div> <!-- form-group -->
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-upload"></i> </span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="postimg" class="custom-file-input" id="customFile" accept="image/*">
                                <label class="custom-file-label" for="customFile">Hình ảnh</label>
                            </div> <!-- form-group -->
                        </div>
                        <?php include('errors.php'); ?>
                        
                        <div class="form-group">
                            <button name="post_the_status" type="submit" class="btn btn-primary btn-block">Đăng</button>
                        </div> <!-- form-group -->
                    </form>
                </article>
            <?php else : ?>
                <p class="text-center">Bạn chưa đăng nhập, hãy <a href="login.php">Đăng Nhập</a> để có thể đăng trạng thái.</p>
            <?php endif ?>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
    <script>
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>

</html>