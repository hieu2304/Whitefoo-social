<?php
    require_once ('vendor/autoload.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //$target_upload_image_dir = "../uploads/img/";

    /* USER */
    function login_user($email, $password)
    {
      global $db, $errors;
      $login_check_query = $db->prepare("SELECT * FROM users WHERE email = ? AND status > ?");
      $login_check_query->execute([$email, 0]);
      $row = $login_check_query->fetch(PDO::FETCH_ASSOC);
  
      if ($row && $email == $row['email'] && password_verify($password, $row['password'])) {
        $_SESSION['profileID'] = $row['profileID'];
        $_SESSION['success'] = "Đăng nhập thành công!";
        header('location: index.php');
      }
      else if ($row && $row['status'] <= 0) {
        array_push($errors, "Bạn cần phải kích hoạt tài khoản để tiếp tục!");
      }
      else {
        array_push($errors, "Sai email hoặc mật khẩu!");
      }
    }

    function register_user($username, $email, $password)
    {
      global $db, $BASE_URL;
      $password = password_hash($password, PASSWORD_DEFAULT); // encrypt the password before saving in the database
      $code = generateRandomString(16);
      // preparing a statement
      $stmt = $db->prepare("INSERT INTO users (username, email, password, code, status) VALUES (?, ?, ?, ?, ?)");
      $stmt->execute([$username, $email, $password, $code, 0]);
      $profileID = $db->lastInsertID();
      //$_SESSION['profileID'] = $profileID;
      $_SESSION['success'] = "Đăng ký thành công!";
      sendEmail($email, $username, 'Kích hoạt tài khoản', "Truy cập liên kết này để kích hoạt tài khoản <a href=\"$BASE_URL/verifyuser.php?code=$code\">$BASE_URL/verifyuser.php?code=$code</a>");
      return $profileID;
      //header('location: index.php');
    }

    function findUserByEmail($email) {
      global $db;
      $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->execute([$email]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function findUserByID($profileID) {
      global $db;
      $stmt = $db->prepare("SELECT * FROM users WHERE profileID = ?");
      $stmt->execute([$profileID]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function findUserByName($name) {
      global $db;
      $stmt = $db->prepare("SELECT * FROM users WHERE username LIKE ? OR fullname LIKE ?");
      $stmt->execute(['%'.$name.'%', '%'.$name.'%']);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function findPostByID($postID) {
      global $db;
      $stmt = $db->prepare("SELECT * FROM posts WHERE postID = ?");
      $stmt->execute([$postID]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function findPostByContent($content) {
      global $db;
      $stmt = $db->prepare("SELECT * FROM posts WHERE content LIKE ?");
      $stmt->execute(['%'. $content .'%']);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function change_password($old_password, $password, $password_retype)
    {
        global $db, $errors, $currentUser;
        if (password_verify($old_password, $currentUser['password']) && $password == $password_retype) {
          $password = password_hash($password, PASSWORD_DEFAULT);
          $password_change_query = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
          $password_change_query->execute([$password, $currentUser['email']]);
          $_SESSION['success'] = "Đổi mật khẩu thành công!";
          header('location: index.php');
        }
        else if ($password != $password_retype) {
          array_push($errors, "Xác nhận mật khẩu mới không chính xác!");
        }
        else {
          array_push($errors, "Sai mật khẩu cũ!");
        }
    }

    function update_profile($id, $username, $fullname, $mobilenumber, $pfp, $pfpType)
    {
      global $db, $errors, $currentUser;
      if ($pfp == null){
        $profile_update_query = $db->prepare("UPDATE users SET username = ?, fullname = ?, mobilenumber = ? WHERE profileID = ?");
        $profile_update_query->execute([$username, $fullname, $mobilenumber, $id]);
      }
      else {
        $pfpData = file_get_contents($pfp['tmp_name']);
        $profile_update_query = $db->prepare("UPDATE users SET username = ?, fullname = ?, mobilenumber = ?, pfp = ?, pfptype = ? WHERE profileID = ?");
        $profile_update_query->execute([$username, $fullname, $mobilenumber, $pfpData, $pfpType, $id]);
      }
      $_SESSION['success'] = "Cập nhật thông tin thành công!";
      header('location: index.php');
    }

    /* STATUS */

    function upload_image($file)
    {
      global $errors;
      $uploadable = false;
      $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
      if ($file["size"] > 8388608) {
        array_push($errors, "Tập tin tải lên quá lớn! (Kích thước tối đa là 8MB)");
        $uploadable = false;
      }
      else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        array_push($errors, "Định dạng tập tin tải lên không hợp lệ! (Chỉ chấp nhận các tập tin hình ảnh đuôi jpg, png, jpeg hoặc gif)");
        $uploadable = false;
      }

      // if everything is ok, try to upload file
      if (count($errors) == 0) {
        // Check if image file is a actual image or fake image
        $check = false;
        if (file_exists($file["tmp_name"])) {
          $check = getimagesize($file["tmp_name"]);
        }
        if ($check == true) {
          $uploadable = true;
        }
        else {
          array_push($errors, "Tập tin không hợp lệ! (Là hình ảnh và nhỏ hơn 8MB)");
          $uploadable = false;
        }
        if ($uploadable) {
          return $file;
        }
      }
      return null;
    }

    function resizeImage($image, $imagetype, $max_width, $max_height)
    {
      $src_image = imagecreatefromstring($image);
      $original_width = imagesx($src_image);
      $original_height = imagesy($src_image);

      if ($original_width < $max_width && $original_height < $max_height)
      {
        $width = $original_width;
        $height = $original_height;
      }
      
      elseif ($original_width > $original_height) 
      {
        $width = $max_width;
        $height = $original_height * ($max_height / $original_width);
      }

      elseif ($original_width < $original_height) 
      {
        $width = $original_width * ($max_width / $original_height);
        $height = $max_height;
      }

      elseif ($original_width == $original_height) 
      {
        $width = $max_width;
        $height = $max_height;
      }

      $new_image = imagecreatetruecolor($width, $height);
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
      $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
      imagefilledrectangle($new_image, 0, 0, $original_width, $original_height, $transparent);
      imagecopyresampled($new_image, $src_image, 0, 0, 0, 0, $width, $height, $original_width, $original_height);

      if ($imagetype == 'jpg' || $imagetype == 'jpeg')
        $output = imagejpeg($new_image);
      else if ($imagetype == 'png')
        $output = imagepng($new_image);
      else if ($imagetype == 'gif')
        $output = imagegif($new_image);
      
      imagedestroy($src_image);
      imagedestroy($new_image);
      return $output; 
    }

    function getNewFeeds()
    {
      global $db;
      $stmt = $db->query("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID ORDER BY p.createdAt DESC");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getNewFeedsPaginate($offset = 0, $postLimit = 10)
    {
      global $db;
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID ORDER BY p.createdAt DESC LIMIT ?, ?");
      $stmt->execute([$offset, $postLimit]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPublicNewFeeds()
    {
      global $db;
      $stmt = $db->query("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.visibility = 0 ORDER BY p.createdAt DESC");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPublicNewFeedsPaginate($offset = 0, $postLimit = 10)
    {
      global $db;
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.visibility = 0 ORDER BY p.createdAt DESC LIMIT ?, ?");
      $stmt->execute([$offset, $postLimit]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPublicNewFeedsByProfileID($profileID)
    {
      global $db;
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.profileID = ? AND p.visibility = 0 ORDER BY p.createdAt DESC");
      $stmt->execute([$profileID]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPublicNewFeedsByProfileIDPaginate($profileID, $offset = 0, $postLimit = 10)
    {
      global $db;
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.profileID = ? AND p.visibility = 0 ORDER BY p.createdAt DESC LIMIT ?, ?");
      $stmt->execute([$profileID, $offset, $postLimit]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getVisibleNewFeeds($profileID)
    {
      global $db;
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp
      FROM posts AS p JOIN users AS u ON p.profileID = u.profileID
      WHERE p.visibility = 0
      OR
        EXISTS (SELECT * FROM friends AS f
        WHERE ((f.userone = ? OR f.usertwo = ?) AND f.status = 1)
        AND (f.userone = p.profileID OR f.usertwo = p.profileID)
        AND p.visibility = 1)
      OR
        EXISTS (SELECT * FROM users AS u2
        WHERE u2.profileID = ?
        AND u2.profileID = p.profileID
        AND p.visibility = 2)
      ORDER BY p.createdAt DESC");
      $stmt->execute([$profileID, $profileID, $profileID]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getVisibleNewFeedsPaginate($profileID, $offset = 0, $postLimit = 10)
    {
      global $db;
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp
      FROM posts AS p JOIN users AS u ON p.profileID = u.profileID
      WHERE p.visibility = 0
      OR
        EXISTS (SELECT * FROM friends AS f
        WHERE ((f.userone = ? OR f.usertwo = ?) AND f.status = 1)
        AND (f.userone = p.profileID OR f.usertwo = p.profileID)
        AND p.visibility = 1)
      OR
        EXISTS (SELECT * FROM users AS u2
        WHERE u2.profileID = ?
        AND u2.profileID = p.profileID
        AND p.visibility = 2)
      ORDER BY p.createdAt DESC
      LIMIT ?, ?");
      $stmt->execute([$profileID, $profileID, $profileID, $offset, $postLimit]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getFriendNewFeedsByFriendID($friendID)
    {
      global $db;
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.profileID = ? AND (p.visibility = 0 OR p.visibility = 1) ORDER BY p.createdAt DESC");
      $stmt->execute([$friendID]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getFriendNewFeedsByFriendIDPaginate($friendID, $offset = 0, $postLimit = 10)
    {
      global $db;
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.profileID = ? AND (p.visibility = 0 OR p.visibility = 1) ORDER BY p.createdAt DESC LIMIT ?, ?");
      $stmt->execute([$friendID, $offset, $postLimit]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getNewFeedsByProfileID($profileID)
    {
      global $db;
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.profileID = ? ORDER BY p.createdAt DESC");
      $stmt->execute([$profileID]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getNewFeedsByProfileIDPaginate($profileID, $offset = 0, $postLimit = 10)
    {
      global $db;
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.profileID = ? ORDER BY p.createdAt DESC LIMIT ?, ?");
      $stmt->execute([$profileID, $offset, $postLimit]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function post_status($id, $content, $img, $imgType, $visibility)
    {
      global $db, $errors;
      if($visibility >= 0 && $visibility < getPrivacyCount())
      {
        if ($img == null){
          $post_insert_query = $db->prepare("INSERT INTO posts(content, profileID, image, visibility) VALUES(?, ?, ?, ?)");
          $post_insert_query->execute([$content, $id, null, $visibility]);
        }
        else {
          $imgData = file_get_contents($img['tmp_name']);
          $post_insert_query = $db->prepare("INSERT INTO posts(content, profileID, image, imagetype, visibility) VALUES(?, ?, ?, ?, ?)");
          $post_insert_query->execute([$content, $id, $imgData, $imgType, $visibility]);
        }
      }
      $_SESSION['success'] = "Đăng trạng thái thành công!";
      header('location: index.php');
    }

    function getPrivacy()
    {
      global $db;
      $stmt = $db->query("SELECT * FROM post_privacy");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPrivacyCount()
    {
      global $db;
      $stmt = $db->query("SELECT COUNT(*) FROM post_privacy");
      return $stmt->fetchColumn();
    }

    function setVisibility($postid, $visibility)
    {
      global $db;
      if($visibility >= 0 && $visibility < getPrivacyCount())
      {
        $stmt = $db->prepare("UPDATE posts SET visibility = ? WHERE postID = ?");
        $stmt->execute([$visibility, $postid]);
        return true;
      }
      return false;
    }

    function detectPage()
    {
      $uri = $_SERVER['REQUEST_URI'];
      $parts = explode('/', $uri);
      $fileName = $parts[2];
      $parts = explode('.', $fileName);
      $page = $parts[0];
      return $page;
    }

    function generateRandomString($length = 10)
    {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }

    /* EMAIL */

    function sendEmail($to, $name, $subject, $content)
    {
      global $EMAIL_FROM, $EMAIL_NAME, $EMAIL_PASSWORD;
      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);
      //Server settings
      $mail->isSMTP();                                            // Send using SMTP
      $mail->CharSet    = 'UTF-8';
      $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = $EMAIL_FROM;                     // SMTP username
      $mail->Password   = $EMAIL_PASSWORD;                               // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
      $mail->Port       = 587;                                    // TCP port to connect to
      //Recipients
      $mail->setFrom($EMAIL_FROM, $EMAIL_NAME);
      $mail->addAddress($to, $name);     // Add a recipient
      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $content;
      // $mail->AltBody = $content;
      $mail->send();
    }

    function activateUser($code)
    {
      global $db;
      $stmt = $db->prepare("SELECT * FROM users WHERE code = ? AND status = ?");
      $stmt->execute(array($code, 0));
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($user && $user['code'] == $code) {
        $stmt = $db->prepare("UPDATE users SET code = ?, status = ? WHERE profileID = ?");
        $stmt->execute(array('', 1, $user['profileID']));
        return true;
      }
      return false;
    }

    function forgotPassword($email)
    {
      global $db, $BASE_URL;
      $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($user && $user['email'] == $email && $user['status'] > 0) {
        // Already requested
        if ($user['status'] == 2) {
          $code = $user['code'];
        }
        else {
          $code = generateRandomString(16);
        }
        $stmt2 = $db->prepare("UPDATE users SET code = ?, status = ? WHERE email = ?");
        $stmt2->execute([$code, 2, $email]);
        sendEmail($email, $user['username'], 'Khôi phục mật khẩu', "Truy cập liên kết này để khôi phục mật khẩu <a href=\"$BASE_URL/passwordreset.php?code=$code\">$BASE_URL/passwordreset.php?code=$code</a>");
        return true;
      }
      return false;
    }

    function verifyResetPassword($code)
    {
      global $db;
      $stmt = $db->prepare("SELECT * FROM users WHERE code = ? AND status = ?");
      $stmt->execute([$code, 2]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($user && $user['code'] == $code) {
        return $user['profileID'];
      }
      return -1;
    }

    function resetPassword($profileID, $password, $password_retype)
    {
      global $db;
      if ($password == $password_retype) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET password = ?, code = ?, status = ? WHERE profileID = ?");
        $stmt->execute([$password, '', 1, $profileID]);
        header('location: login.php');
      }
    }

    function CheckAvatarIsNullByUserID($profileID) 
    {
      global $db;
      $stmt = $db->prepare("SELECT * FROM users WHERE profileID = ?");
      $stmt->execute([$profileID]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if($user['pfp']==NULL or $user['pfp']=="")
      {
        // nếu người này không có ảnh đại diện thì return 0
        return 0;
      }
      // nếu người này không có ảnh đại diện thì return 1
      return 1;
    }

    function deletePost_By_profileID_postID($profileID,$postID)
    {
      global $db;
      $stmt = $db->prepare("DELETE FROM posts WHERE profileID = ? AND postID = ?");
      $stmt->execute([$profileID,$postID]);
      return 0;
    }

    /* FRIEND */

    function sendFriendRequest($profileID1, $profileID2)
    {
      global $db, $BASE_URL;
      $email = $db->prepare("SELECT email FROM users WHERE profileID = ? ");
      $email->execute([$profileID2]);
      $email1 = $email->fetchColumn();
      $name = $db->prepare("SELECT username FROM users WHERE profileID = ? ");
      $name->execute([$profileID2]);
      $name1 = $name->fetchColumn();
      $sendername = $db->prepare("SELECT username FROM users WHERE profileID = ? ");
      $sendername->execute([$profileID1]);
      $result = $sendername->fetchColumn();
      $stmt = $db->prepare("INSERT INTO friends (userone, usertwo, status) VALUE(?, ?, 0)");
      $stmt->execute([$profileID1,$profileID2]);
      sendEmail($email1, $name1,'Thông báo lời mời kết bạn', $result . " đã gửi lời mời kết bạn đến bạn<br>Xem ngay: <a href=\"$BASE_URL/personalpage.php?id=$profileID1\">$BASE_URL/personalpage.php?id=$profileID1</a>");
       // sendEmail($email, $username, 'Kích hoạt tài khoản', "Truy cập liên kết này để kích hoạt tài khoản <a href=\"$BASE_URL/verifyuser.php?code=$code\">$BASE_URL/verifyuser.php?code=$code</a>");
    }

    function acceptFriendRequest($profileID1, $profileID2)
    {
      global $db;
      $stmt = $db->prepare("UPDATE friends SET status = ? WHERE (userone = ? AND usertwo = ?) OR (usertwo = ? and userone = ? ) AND status = 0");
      $stmt->execute([1, $profileID1, $profileID2, $profileID1, $profileID2]);
    }

    function getFriendRequestStatus($profileID1, $profileID2)
    {
      global $db;
      $stmt = $db-> prepare("SELECT userone,usertwo,status FROM friends WHERE (userone = ? AND usertwo = ?) OR (usertwo = ? and userone = ? )");
      $stmt->execute([$profileID1,$profileID2,$profileID1,$profileID2]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function removeFriendRequest($profileID1, $profileID2)
    {
      global $db;
      $stmt = $db ->prepare("DELETE FROM friends WHERE (userone = ? and usertwo = ?) OR (usertwo = ? and userone = ?)");
      $stmt -> execute([$profileID1, $profileID2,$profileID1, $profileID2]);
    }
    
    function insertLike_By_profileID_postID($profileID,$postID)
    {
      global $db;
      if(kiemtraLikechua($profileID,$postID)==0)
      {
        $stmt = $db->prepare("INSERT INTO likes (id_users,id_posts) VALUE(?,?)");
        $stmt->execute([$profileID,$postID]);
      }
      else  
        return 0;
    }
    function laysoLike_By_postID($postID)
    {
      global $db;
      $count = $db->query("SELECT count(*) FROM likes")->fetchColumn();
      $stmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE id_posts = ? ");
      $stmt->execute([$postID]);
      $count=$stmt->fetchColumn();
      return $count;
    }
    function kiemtraLikechua($profileID,$postID)
    {
      global $db;
      $stmt=$db->prepare("SELECT* FROM likes WHERE  id_users=? AND id_posts = ? ");
      $stmt->execute([$profileID,$postID]);
      $like=$stmt->fetch(PDO::FETCH_ASSOC);
      if($like && $like['id_posts']==$postID){
        return 1;
      }
      return 0;
    }

    function deleteLike_By_profileID_postID($profileID,$postID)
    {
      global $db;
      if(kiemtraLikechua($profileID,$postID)==1)
      {
        $stmt = $db->prepare("DELETE  FROM likes WHERE id_users = ? AND id_posts = ?");
        $stmt->execute([$profileID,$postID]);
      }
      else
        insertLike_By_profileID_postID($profileID,$postID);
    }
    function getNewCommentsByProfileIDPaginate($profileID, $offset = 0, $postLimit = 10)
    {
      global $db;
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM comments AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.profileID = ? ORDER BY p.Time_cmt DESC LIMIT ?, ?");
      $stmt->execute([$profileID, $offset, $postLimit]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  
    function isFriend($profileID, $friendID)
    {
      global $db;
      $stmt = $db->prepare("SELECT COUNT(*) FROM friends WHERE ((userone = ? AND usertwo = ?) OR (usertwo = ? AND userone = ?)) AND status = 1");
      $stmt->execute([$profileID, $friendID, $profileID, $friendID]);
      $result = $stmt->fetchColumn();
      if ($result > 0)
        return true;
      return false;
    }

   /* CONVERSATION */

  function getConversationByProfileID($profileID)
  {
    global $db;
    $stmt = $db->prepare("SELECT c.conversationID FROM conversations AS c JOIN conversations_users AS u ON c.conversationID = u.conversationID WHERE u.profileID = ?");
    $stmt->execute([$profileID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function getConversationByProfileIDPaginate($profileID, $offset, $limit)
  {
    global $db;
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $stmt = $db->prepare("SELECT c.* FROM conversations AS c JOIN conversations_users AS u ON c.conversationID = u.conversationID WHERE u.profileID = ? LIMIT ?, ?");
    $stmt->execute([$profileID, $offset, $limit]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function getMessagesByConversation($conversationID)
  {
    global $db;
    $stmt = $db->prepare("SELECT m.*, c.*, s.message, s.time FROM conversations_messages AS m JOIN conversations AS c ON m.conversationID = c.conversationID 
      JOIN conversations_sent AS s ON m.messageID = s.messageID
      WHERE c.conversationID = ? AND s.profileID = m.profileID  ORDER BY s.time ASC");

    $stmt->execute([$conversationID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function getMessagesByConversationPaginate($conversationID, $offset, $limit)
  {
    global $db;
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $stmt = $db->prepare("SELECT m.*, c.*, s.message, s.time FROM conversations_messages AS m J
      OIN conversations AS c ON m.conversationID = c.conversationID JOIN conversations_sent AS s ON m.messageID = s.messageID 
      WHERE c.conversationID = ? AND s.profileID = m.profileID ORDER BY s.time ASC LIMIT ?, ?");

    $stmt->execute([$conversationID, $offset, $limit]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  //các hàm sử dụng cho tin nhắn

  function getConversationByProfileIDNoLastMessage($profileID)
  {
    global $db;
    $stmt = $db->prepare("SELECT c.conversationID FROM conversations AS c 
    JOIN conversations_users AS u ON c.conversationID = u.conversationID WHERE u.profileID = ? AND c.lastMessageID !=0 
    ORDER BY c.lastMessageID DESC;");
    $stmt->execute([$profileID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function checkTheseUsersInConverYet($profileID1, $profileID2)
  {
    global $db;
    $stmt = $db->prepare("SELECT u.conversationID FROM conversations_users AS u 
    JOIN conversations_users AS u2 ON u2.conversationID=u.conversationID WHERE u.profileID = ? AND u2.profileID = ?;");

    $stmt->execute([$profileID1,$profileID2]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  //nếu đã tồn tại cuộc trọ chuyện thì trả ra ID cuộc trò chuyện, ngược lại tạo rồi trả
  function startingChat($profileID1,$profileID2)
  {
    $result = checkTheseUsersInConverYet($profileID1,$profileID2);
      if(!$result):
        global $db;
        //thêm rồi lấy ra ID trong 1 cú query
        $stmt = $db->prepare("INSERT INTO conversations(lastMessageID) VALUES(?);");     
        $stmt->execute([0]);
        $stmt = $db->prepare("SELECT max(u.conversationID) FROM conversations AS u;");
        $stmt->execute();
        $temp = $stmt->fetch(PDO::FETCH_ASSOC);
        $conversationID = $temp['max(u.conversationID)'];
        $stmt = $db->prepare("INSERT INTO conversations_users VALUES(?, ?, 0);");     
        $stmt->execute([$conversationID, $profileID1]);
        $stmt = $db->prepare("INSERT INTO conversations_users VALUES(?, ?, 0);");     
        $stmt->execute([$conversationID, $profileID2]);
        $result = checkTheseUsersInConverYet($profileID1,$profileID2);
      endif;
    return $result;
  }

  function getTwoUserIDByConversationID($conversationID)
  {
    global $db;
    $stmt = $db->prepare("SELECT u.profileID AS 'profileID1', u2.profileID AS 'profileID2' FROM conversations_users AS u 
      JOIN conversations_users AS u2 ON u.conversationID=u2.conversationID WHERE u.conversationID = ? AND u.profileID != u2.profileID LIMIT 1;");
 
    $stmt->execute([$conversationID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function getAnotherUserIDByConversationIDAndUserID($conversationID, $profileID)
  {
    global $db;
    $stmt = $db->prepare("SELECT u.profileID FROM conversations_users AS u WHERE u.conversationID = ? AND u.profileID != ?;");
 
    $stmt->execute([$conversationID, $profileID]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  function getAllRecentMessages($profileID)
  {
    //lấy toàn bộ conver ko theo thời gian
    $allConversations = getConversationByProfileIDNoLastMessage($profileID);
    $totallist = [];
    global $db;
    $temp;
    // u.proileID là người mà ta đang nói chuyện, sender là ngườii gửi tin nhắn
    //mỗi cuộc trò chuyện trả ra sẽ có thông tin tên+ảnh của đối phương chat, tin nhắn gần nhất (mình/đối phương), sắp theo thgian, gần nhất là đầu tiên
    $stmt = $db->prepare("SELECT m.deleted, c.conversationID ,s.time, s.message, s.messageID, s.profileID as 'senderID' 
    FROM conversations AS c JOIN conversations_messages AS m ON m.messageID = c.lastMessageID
    JOIN conversations_sent AS s ON s.messageID = c.lastMessageID
    WHERE c.conversationID = ? AND m.profileID = ? AND c.lastMessageID!=0
    ORDER BY s.time DESC;");

    foreach($allConversations as $conversation):
      $stmt->execute([$conversation['conversationID'], $profileID]);      
      $temp = $stmt->fetch(PDO::FETCH_ASSOC);
      if($temp['deleted'] == 1 ):
        $newProperties = getPreMessagePropertiesOfMessageDeleted($temp['conversationID'], $temp['messageID']);
        if($newProperties != null):
          $temp['deleted'] = 0;
          $temp['time'] = $newProperties['time'];
          $temp['message'] = $newProperties['message'];
          $temp['senderID'] = $newProperties['profileID'];
          $temp['message'] = str_replace("<br>","",$temp['message']);
          $temp['message'] = shortcutString($temp['message'],14);      
          array_push($totallist,$temp);
        endif;
      else:
        $temp['message'] = str_replace('<br>'," ", $temp['message']);
        $temp['message'] = shortcutString($temp['message'],14);
        array_push($totallist,$temp);
      endif;
    endforeach;
    return $totallist;
  }

  function senddingMessage($profileID, $conversationID, $message)
  {
    global $db;
    //thêm vào sent với ID người gửi
    $stmt = $db->prepare("INSERT INTO conversations_sent(message, profileID) VALUES(?, ?);");     
    $stmt->execute([$message, $profileID]);
    $stmt = $db->prepare("SELECT max(s.messageID) FROM conversations_sent AS s;");     
    $stmt->execute();
    $temp = $stmt->fetch(PDO::FETCH_ASSOC);
    $messageID = $temp['max(s.messageID)'];
    $profileID2 = getAnotherUserIDByConversationIDAndUserID($conversationID, $profileID);
    //thêm vào messages
    //thêm ng gửi trước
    $stmt = $db->prepare("INSERT INTO conversations_messages VALUES(?, ?, ?, 0, 0);");    
    $stmt->execute([$conversationID, $messageID, $profileID]);
    //thêm người nhận
    $stmt = $db->prepare("INSERT INTO conversations_messages VALUES(?, ?, ?, 0, 0);");   
    $stmt->execute([$conversationID, $messageID, $profileID2['profileID']]);

    //thêm vào conver chính
    $stmt = $db->prepare("UPDATE conversations AS c SET lastMessageID = ? WHERE c.conversationID = ?;");
    $stmt->execute([$messageID, $conversationID]);

    //xog hết thì gửi mail thông báo cho người nhận tin nhắn(Another User)
    $temp = $profileID2['profileID'];
    $anotherUser = findUserByID((int)$temp);
    $sendUser = findUserByID($profileID);
    $currentUserShortcutName = '';
    if( !($sendUser['fullname'] == "" || $sendUser['fullname'] == null) ):
      $currentUserShortcutName = $sendUser['fullname'];
    else:
      $currentUserShortcutName = $sendUser['username'];
    endif;
    if(isset($currentUserShortcutName )):
      $currentUserShortcutName = shortcutString($currentUserShortcutName,20);
    else:
      $currentUserShortcutName = "Người dùng";
    endif;
    $messageTitle = "Bạn có tin nhắn mới từ [" . $currentUserShortcutName . "]";
    $messageContent = "Nội dung: " . "<br>" . shortcutString($message,100);

    sendEmail($anotherUser['email'], $temp, $messageTitle, $messageContent);
  }

  function getFriendIDCol2($profileID)
  {
    //lấy danh sách bạn bè khi user hiện tại nằm ở cột 1, friend cột 2
    global $db;
    $stmt = $db->prepare("SELECT f.usertwo AS 'friendID' FROM friends f WHERE f.userone = ? AND f.status = 1");
    $stmt->execute([$profileID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function getFriendIDCol1($profileID)
  {
    //lấy danh sách bạn bè khi user hiện tại nằm ở cột 2, friend cột 1
    global $db;
    $stmt = $db->prepare("SELECT f.userone AS 'friendID' FROM friends f WHERE f.usertwo = ? AND f.status = 1");
    $stmt->execute([$profileID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function shortcutString($inputString, $limit)
  {
    $result = $inputString;
    $lengthStr = strlen($inputString);
    if($lengthStr > $limit)
    {
      $result = null;
      $result = substr( $inputString, 0, $limit);
      $newLengthStr = strripos($result,' ',0);
      if($newLengthStr>1):
        $result = substr( $inputString, 0, $newLengthStr);
      else:
        $result = substr( $inputString, 0, $limit-4);
      endif;
      $result = $result . '...';
    }
    return $result;
  }

  function getFriendList($profileID)
  {
      $lista=getFriendIDCol2($profileID);
      $listb=getFriendIDCol1($profileID);
      $totallist=[];
      foreach($lista as $i)
      {
        $temp = findUserByID($i['friendID']);
        //cắt bớt tên
        $temp['username'] = shortcutString($temp['username'],45);
        if(isset($temp['fullname'])):
          $temp['fullname'] = shortcutString($temp['fullname'],45);
        endif;
        array_push($totallist,$temp);
      }
      foreach($listb as $j)
      {
        $temp = findUserByID($j['friendID']);
        $temp['username'] = shortcutString($temp['username'],45);
        if(isset($temp['fullname'])):
          $temp['fullname'] = shortcutString($temp['fullname'],45);
        endif;
        array_push($totallist,$temp);
      }
      return $totallist;
  }

  function getUserList($profileID)
  {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users AS u WHERE u.profileID != ?;");
    $stmt->execute([$profileID]);
    $list= $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totallist=[];
    foreach($list as $i)
      {
        $temp = $i;
        $temp['username'] = shortcutString($temp['username'],45);
        if(isset($temp['fullname'])):
          $temp['fullname'] = shortcutString($temp['fullname'],45);
        endif;
        array_push($totallist,$temp);
      }
      return $totallist;
  }

  function deleteMessage($conversationID, $messageID, $profileID)
  {
    global $db;
    $stmt = $db->prepare("UPDATE conversations_messages SET deleted = 1 WHERE conversationID = ? AND messageID = ? AND profileID = ?;");
    $stmt->execute([$conversationID, $messageID, $profileID]);
  }

  function getPrevMessageIDOfMessageDeleted($conversationID, $messageID)
  {
    global $db;
    $stmt = $db->prepare("SELECT max(m.messageID) AS 'messageID' FROM conversations_messages AS m 
    WHERE m.conversationID = ? AND m.messageID !=? AND m.deleted != 1;");
    $stmt->execute([$conversationID, $messageID]);
    return $stmt->fetch(PDO::FETCH_ASSOC); //gìđó['messageID']
  }

  function getPreMessagePropertiesOfMessageDeleted($conversationID, $messageID)
  {
    $temp = getPrevMessageIDOfMessageDeleted($conversationID, $messageID);
    $newMessageID = $temp['messageID'];
    if($newMessageID):
      global $db;
      $stmt = $db->prepare("SELECT s.* FROM conversations_sent AS s 
      JOIN conversations_messages AS m ON m.messageID = s.messageID 
      WHERE s.messageID =? AND s.profileID = m.profileID;");
      $stmt->execute([$newMessageID]);
      return $stmt->fetch(PDO::FETCH_ASSOC); //gìđó['messageID']
    endif;
    return null;
  }
    
?>