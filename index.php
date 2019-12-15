<?php
    require_once('init.php');
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
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/status.css">
    <link rel="stylesheet" href="assets/css/spinners/style.css">
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
                                <h1>ĐĂNG KÝ NGAY</h1>
                                <button class="btn btn-light btn-lg action-button" type="button" Onclick="window.location.href='register.php'">Đăng Ký Ngay</button></div>
                            <div class="col-md-5 col-lg-5 offset-lg-1 offset-xl-0 d-none d-lg-block phone-holder">
                                <div class="center-img">
                                    <img class="lazyload" data-src="assets\img\fox-1284512_1920.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="container hero">
                        <div class="row">
                            <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
                                <h1>Xin chào, <?php echo ($currentUser["fullname"] != "" || $currentUser["fullname"]) != null ? $currentUser["fullname"] : $currentUser["username"] ?></h1>
                                <button class="btn btn-light btn-lg action-button" type="button" onClick="document.getElementById('newfeed').scrollIntoView();">Xem các bài viết</button></div>
                            <div class="col-md-5 col-lg-5 offset-lg-1 offset-xl-1 d-none d-lg-block">
                                <div class="center-avatar">
                                    <?php if (isset($currentUser['pfp'])): ?>
                                        <img class="lazyload" data-src="profilepfp.php?id=<?php echo $currentUser['profileID']; ?>">
                                    <?php else: ?>
                                        <img class="lazyload" data-src="assets\img\defaultavataruser.png">
                                    <?php endif?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="newfeed" style="margin-top: 200px; font-family: 'Roboto', sans-serif;">
                        <div class="row" id="newfeed_content">
                        </div>
                    </div>
                    <div id="load_more" class="col-sm-12 mt-5 text-center">
                        <div id="spinner"></div>
                        <button id="button_more" name="button_more" style="display: none" data-page="<?php echo $currentPage ?>" class="btn btn-primary">Xem thêm</button>
                    </div>
                <?php endif ?> 
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
    <script src="assets/js/content-p.js"></script>
    <script src="assets/js/privacychange.js"></script>
</body>

</html>