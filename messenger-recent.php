<?php require_once('init.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Nhắn tin - WhiteFoo</title>
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
                    <?php $allRecentMessages = getAllRecentMessages($_SESSION['profileID']); ?>    
                    <div class="chat-master">
                        <div class="card" style="height:650px;">
                            <div class="card-header msg_head">
                                <div class="d-flex bd-highlight">
                                    <div class="user_info" style="min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center; padding-bottom:10px;">
                                        <span style="font-size:30px; font-weight:bold; padding-left:5px; float:left;">
                                        <i class="fa fa-comments"></i> Các cuộc trò chuyện gần đây
                                        </span>
                                        <span style="font-size:30px; font-weight:bold; float:right; padding-right:15px;">
                                            <a href ="messenger-new.php">
                                                <button class="newmessagebtn"><i style="font-size:30px;" class="fa fa-pencil-square-o"></i> Tin nhắn mới</button>
                                            </a>  
                                        </span>                                                           					
                                    </div>
                                </div>
                                <div class="d-flex bd-highlight">
                                    <div class="user_info" style="min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center;">
                                        <span>
                                            <input type="text" id="myInput2" onkeyup="SearchingFunc2()" placeholder= "Tìm kiếm gần đây..." title="Tìm kiếm người mà bạn từng trò chuyện ít nhất 1 lần...">
                                        </span>                                                					
                                    </div>
                                </div>         
                            </div>
                            <div class="card-body msg_card_body" style="overflow-x: auto;">                    
                                <ul id="myUL2" value="Các cuộc trò chuyện gần đây">

                                <?php foreach($allRecentMessages as $singleRecent):
                                    $anotherUserID =  getAnotherUserIDByConversationIDAndUserID($singleRecent['conversationID'],$_SESSION['profileID'] );
                                    $anotherUser = findUserByID($anotherUserID['profileID']);
                                    $anotherUser['username'] = shortcutString($anotherUser['username'],18);
                                    $anotherUser['fullname'] = shortcutString($anotherUser['fullname'],18);
                                ?>
                                    <div class="recent-wraper">                                                       
                                        <li>
                                            <a href="messenger.php?conversationID=<?php echo $singleRecent['conversationID'];?>&profileID=<?php echo $_SESSION['profileID']; ?>">
                                                <div class="mini-avatar-recent" value="ảnh nhỏ">
                                                    <?php if (isset($anotherUser["pfp"])): ?>
                                                        <img class="lazy" data-src="profilepfp.php?id=<?php echo $anotherUser['profileID'];?>">
                                                    <?php else: ?>
                                                        <img class="lazy" data-src="assets/img/defaultavataruser.png">                                  
                                                    <?php endif?> 
                                                </div>
                                                <div class="mini-name-mes-recent" value ="tên">
                                                    <div class="mini-name-recent">
                                                        <?php echo ($anotherUser["fullname"] != "" || $anotherUser["fullname"]) != null ? $anotherUser["fullname"] : $anotherUser["username"]; ?>
                                                    </div>
                                                    <div class="mini-mes-recent">
                                                        <?php
                                                            if($_SESSION['profileID'] == $singleRecent['senderID']):
                                                                echo 'Bạn:';
                                                            endif; 
                                                        ?>
                                                        <?php echo $singleRecent['message']; ?>               
                                                    </div>   
                                                    <div class="mini-mes-recent">• <?php echo $singleRecent['time']; ?></div> 
                                                </div>                                           
                                            </a>       
                                        </li>
                                        </div>
                                        <div class="recent-wraper">
                                        <div id="break_space_between_posts"></div>
                                            
                                 <?php endforeach; ?>
                                </ul>                            
                            </div>
                        </div>
                            <div class="card-footer" style="padding-bottom:1%; font-size:13.5px;">
                                <div class="d-flex bd-highlight">
                                    <div class="user_info" style="min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center; color:white; padding-bottom:10px;">
                                        "Tìm kiếm gần đây" dùng để tìm kiếm những người mà bạn đã từng nhắn tin.                                             					
                                    </div>
                                </div>
                                <div class="d-flex bd-highlight">
                                    <div class="user_info" style="min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center; color:white; padding-bottom:10px;">
                                        "tin nhắn mới" dùng để tìm kiếm và nhắn những người tham gia mạng xã hội này.                                             					
                                    </div>
                                </div>  
                                <div class="d-flex bd-highlight">
                                    <div class="user_info" style="min-width:10%; width:100%; max-width:100%; text-align:center; align-self: center; color:white; padding-bottom:10px;">
                                       Còn một cách khác để nhắn tin, hãy dùng công cụ tìm kiếm ở Đầu của trang (kế bên "danh sách bạn bè") rồi chọn "Gửi tin nhắn".                                         					
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