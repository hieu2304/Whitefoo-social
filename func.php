<?php
    require_once ('vendor/autoload.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //$target_upload_image_dir = "../uploads/img/";

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

    function findPostByID($postID) {
      global $db;
      $stmt = $db->prepare("SELECT * FROM posts WHERE postID = ?");
      $stmt->execute([$postID]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
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

    function upload_image($file)
    {
      global $errors, $target_upload_image_dir;
      $uploadable = false;
      $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
      if ($file["size"] > 2097152) {
        array_push($errors, "Tập tin tải lên quá lớn! (Kích thước tối đa là 2MB)");
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
          array_push($errors, "Tập tin không hợp lệ! (Là hình ảnh và nhỏ hơn 2MB)");
          $uploadable = false;
        }
        if ($uploadable) {
          return $file;
        }
      }
      return null;
    }

    /*
    function resizeImage($filename, $max_width, $max_height)
    {
      list($orig_width, $orig_height) = getimagesize($filename);
    
      $width = $orig_width;
      $height = $orig_height;
    
      # taller
      if ($height > $max_height) {
          $width = ($max_height / $height) * $width;
          $height = $max_height;
      }
    
      # wider
      if ($width > $max_width) {
          $height = ($max_width / $width) * $height;
          $width = $max_width;
      }
    }
    */

    function getNewFeeds()
    {
      global $db;
      $stmt = $db->query("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID ORDER BY p.createdAt desc");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getNewFeedsByProfileID($profileID)
    {
      global $db;
      $stmt = $db->prepare("SELECT p.*, u.username, u.fullname, u.pfp FROM posts AS p JOIN users AS u ON p.profileID = u.profileID WHERE p.profileID = ? ORDER BY p.createdAt desc");
      $stmt->execute([$profileID]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function post_status($id, $content, $img, $imgType)
    {
      global $db, $errors;
      if ($img == null){
        $post_insert_query = $db->prepare("INSERT INTO posts(content, profileID, image) VALUES(?, ?, '')");
        $post_insert_query->execute([$content, $id]);
      }
      else {
        $imgData = file_get_contents($img['tmp_name']);
        $post_insert_query = $db->prepare("INSERT INTO posts(content, profileID, image, imagetype) VALUES(?, ?, ?, ?)");
        $post_insert_query->execute([$content, $id, $imgData, $imgType]);
      }
      $_SESSION['success'] = "Đăng trạng thái thành công!";
      header('location: index.php');
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
?>