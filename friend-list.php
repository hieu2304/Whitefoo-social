<?php require_once('init.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Danh sách bạn bè - WhiteFoo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Header-Blue.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/messenger-style.css">
    <script src="assets/js/searching-approximately.js"></script>
</head>

<body>
    <div>
        <div class="header-blue">
            <?php include '_nav.php'; ?>      
            <div id="content">
                <div class="bg-transparent border-0 text-dark">
                    <?php if (isset($_SESSION['profileID'])): ?>
                    <?php $friends = getFriendList($_SESSION['profileID']); ?> 
                    <div class="chat-master">
                        <div class="card" style="height: 680px;">
                            <div class="card-header msg_head">
                                <div class="d-flex bd-highlight">
                                    <div class="user_info" style="min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center; padding-bottom:10px;">
                                        <span style="font-size:30px; font-weight:bold;">
                                        <i class="fa fa-users"></i> Danh Sách bạn bè
                                        </span>                                                       					
                                    </div>
                                </div>
                                <div class="d-flex bd-highlight">
                                    <div class="user_info" style="min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center;">
                                        <span>
                                            <input type="text" id="myInput2" onkeyup="SearchingFunc2()" placeholder= "Tìm kiếm bạn bè..." title="Tìm kiếm người đã có kết bạn với bạn...">
                                        </span>                                                					
                                    </div>
                                </div>         
                            </div>
                            <div class="card-body msg_card_body" style="overflow-x: auto;">                       
                                <ul id="myUL2" value="Danh sách bạn bè">
                                    <?php if($friends): ?>
                                    <?php foreach($friends as $friend): ?>
                                    <div class="friend-wrapper">                                                                              
                                        <li id>
                                            <a href="personalpage.php?id=<?php echo $friend["profileID"] ?>">
                                                <div class="mini-avatar-recent" value="ảnh nhỏ">
                                                    <?php if (isset($friend["pfp"])): ?>
                                                        <img class="lazyload" data-src="profilepfp.php?id=<?php echo $friend['profileID'];?>&width=450&height=450" src="profilepfp.php?id=<?php echo $friend['profileID'];?>&placeholder">
                                                    <?php else: ?>
                                                        <img class="lazyload" data-src="assets/img/defaultavataruser.png">                                  
                                                    <?php endif?>
                                                </div>
                                                <div class="mini-name-friend" value ="tên">
                                                    <div class="mini-name-recent" id="showing-in-friend-list"><?php echo ($friend["fullname"] != "" || $friend["fullname"]) != null ? $friend["fullname"] : $friend["username"] ?></div>                       
                                                </div>                                           
                                            </a>                                  
                                        </li>
                                    </div>
                                    <div id="break_space_between_posts"></div>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <div class="d-flex bd-highlight">
                                        <div class="user_info" style="font-size:35px; min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center; color:white; padding-bottom:10px;">
                                            Hiện tại bạn không có người bạn nào, hãy mau tìm kiếm bạn bè và kết bạn nhé.                                    					
                                        </div>
                                    </div>
                                    <?php endif;?>                                                                   
                                </ul>
                            </div>
                        </div>
                            <div class="card-footer" style="padding-bottom:1%; font-size:13.5px;">
                                <div class="d-flex bd-highlight">
                                    <div class="user_info" style="min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center; color:white; padding-bottom:10px;">
                                        "Nhắn tin" để vào cửa sổ chat với người bạn mà bạn vừa bấm.                                         					
                                    </div>
                                </div>
                                <div class="d-flex bd-highlight">
                                    <div class="user_info" style="min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center; color:white; padding-bottom:10px;">
                                        "Hủy kết bạn" khi một mối quan kệ kết thúc với người nào đó trong danh sách bạn bè, suy nghĩ rồi hãy nhấn nút này.
                                    </div>
                                </div>  				
                            </div>
                        </div>
                    </div>              
                    <?php else : ?>
                        <p class="text-center">Bạn chưa đăng nhập, hãy <a href="login.php">Đăng Nhập</a> để có thể đăng sử dụng tính năng này.</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
</body>

</html>