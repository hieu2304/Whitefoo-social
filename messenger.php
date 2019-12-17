<?php require_once('init.php');
ob_start();?>
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
    <script src="assets/js/modifypost.js"></script>
    <script src ="assets/js/autoScrolling.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/emoji-button@latest/dist/index.min.js"></script>
    <Script src ="assets/js/emoji.js"></script>
    <link rel="stylesheet" href="assets/css/Header-Blue.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/messenger-style.css">
</head>
<body>
    <div>
        <div class="header-blue">
            <?php include '_nav.php'; ?>
            <div id="content">
                <div class="bg-transparent border-0 text-dark">
                <?php if (isset($_SESSION['profileID'])): ?>
                    <?php if (isset($_GET['conversationID']) and isset($_GET['profileID'])):
                        $conversationID = $_GET['conversationID'];
                        $currenUserID = $_GET['profileID'];
                        $temp = getAnotherUserIDByConversationIDAndUserID($conversationID, $currenUserID);
                        $anotherUserID = $temp['profileID'];
                        $anotherUser = findUserByID($anotherUserID);
                        $anotherUser['username'] = shortcutString($anotherUser['username'],90);
                        if (isset($anotherUser['fullname']))
                            $anotherUser['fullname'] = shortcutString($anotherUser['fullname'],90);
                        $allMessages = getMessagesByConversation($conversationID);
                        global $currentUser;
                    ?>                
                    <div class="chat-master">
                        <div style="height:20%; position: relative; background-color: transparent;">
                            <a href ="messenger-recent.php">
                                <button class="recentbtn"><i style="font-size:27px;" class="fa fa-indent"></i> gần đây</button>
                            </a>                    
                        </div>  
                    <div class="card">
                        <div class="card-header msg_head">
                            <div class="d-flex bd-highlight">
                                <div class="img_cont" style="float:left;">                                 
                                    <?php if (isset($anotherUser['pfp'])): ?>
                                        <img class="lazyload rounded-circle user_img" data-src="profilepfp.php?id=<?php echo (int)$anotherUserID; ?>&width=450&height=450" src="profilepfp.php?id=<?php echo (int)$anotherUserID; ?>&placeholder">
                                    <?php else: ?>
                                        <img class="lazyload rounded-circle user_img" data-src="assets\img\defaultavataruser.png" >
                                    <?php endif?>                      
                                </div>
                                <div class="user_info" style="min-width:10%; width:70%; max-width:70%; float:left;">
                                    <span>
                                        <?php echo ($anotherUser["fullname"] != "" || $anotherUser["fullname"]) != null ? $anotherUser["fullname"] : $anotherUser["username"]; ?>
                                    </span>                                     
                                </div>
                            </div>        
                        </div>
                        <div class="card-body msg_card_body" id="messagingbody">                           
                            <?php foreach($allMessages as $message): ?>                       
                            <?php if($message['profileID'] == $currenUserID and $message['deleted'] != 1): ?>
                            <div class="d-flex justify-content-end mb-4" id="messaging" value="<?php echo 'msg' . $message['messageID']; ?>">
                                <button value="<?php echo $currenUserID. '+' .$conversationID. '=' .$message['messageID'].'-deletemessagebtn'; ?>" onclick="getbuttonvalue(this)" class="btn-delete-mes" >x</button>
                                <div class="msg_cotainer_send">
                                    <?php echo $message['message']; ?>
                                    <span class="msg_time_send"> <?php echo $message['time']; ?> </span>
                                </div>
                                <div class="img_cont_msg">
                                    <?php if (isset($currentUser['pfp'])): ?>
                                        <img class="lazyload rounded-circle user_img_msg" data-src="profilepfp.php?id=<?php echo $currentUser['profileID']; ?>&width=450&height=450" src="profilepfp.php?id=<?php echo $currentUser['profileID']; ?>&placeholder">
                                    <?php else: ?>
                                        <img class="lazyload rounded-circle user_img_msg" data-src="assets\img\defaultavataruser.png" >
                                    <?php endif?>
                                </div>
                            </div>                            
                            <?php elseif($message['profileID'] != $currenUserID): ?>                           
                            <div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <?php if (isset($anotherUser['pfp'])): ?>
                                        <img class="lazyload rounded-circle user_img_msg" data-src="profilepfp.php?id=<?php echo (int)$anotherUserID; ?>&width=450&height=450" src="profilepfp.php?id=<?php echo (int)$anotherUserID; ?>&placeholder">
                                    <?php else: ?>
                                        <img class="lazyload rounded-circle user_img_msg" data-src="assets\img\defaultavataruser.png" >
                                    <?php endif?>
                                </div>
                                <div class="msg_cotainer" id="temp">
                                    <?php echo $message['message']; ?>
                                    <span class="msg_time"> <?php echo $message['time']; ?> </span>
                                </div>                            
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button id="emoji-button" class="input-group-text my_emoji_btn" style="width:50px; background-color: transparent;"><img draggable="false" class="emoji" alt="😀" src="https://s.w.org/images/core/emoji/12.0.0-1/svg/1f600.svg" style="width:30px; background-color: transparent;"></button>
                                </div>
                                <textarea id="inputmessagehere" class="form-control type_msg" style="border-radius: 0px 0px 0px 0px;" placeholder="Nhập tin nhắn..."></textarea>                               
                                <div class="input-group-append">
                                    <button value="<?php echo $conversationID.'='.$currenUserID.'-sendbtn'; ?>" onclick="getbuttonvalue(this)" class="input-group-text send_btn" style="color:white; font-size: 30px;">                                                                 
                                        <i class="fas fa-location-arrow"> </i>                                                                  
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>                
                    <?php else: header('location: messenger-recent.php'); exit(); ?>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                    <p class="text-center">Bạn chưa đăng nhập, hãy <a href="login.php">Đăng Nhập</a> để có thể đăng sử dụng tính năng này.</p>
                <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <?php include '_footer.php'; ?>
</body>
<script>
    window.onload = scrollling(500);
</script>
</html>