<?php
// Load core functions
require_once('vendor/autoload.php');
//require_once ('./vendor/autoload.php');
// Always display errors
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting (E_ALL);

//Load main functions
require_once ('func.php');
require_once ('config.php');

// Start session
session_start();

// Detect page
$page = detectPage();

// initializing variables
$info = null;
$errors = array();

// connect to the db
try {
  $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASSWORD);
}
catch (PDOException $ex) {
  echo "Error connecting to mysql: " . $ex->getMessage();
}
$currentUser = null;

if (isset($_SESSION['profileID'])) {
  $currentUser = findUserByID($_SESSION['profileID']);
  $currentUser['username'] = htmlspecialchars($currentUser['username']);
  $currentUser['fullname'] = htmlspecialchars($currentUser['fullname']);
  $currentUser['mobilenumber'] = htmlspecialchars($currentUser['mobilenumber']);
}

// REGISTER NEW USER
if (isset($_POST['register_new'])) {
  // receive all input values from the form
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password_retype = $_POST['password_retype'];

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Tên người dùng là bắt buộc"); }
  if (empty($email)) { array_push($errors, "Email là bắt buộc"); }

  // check exited username in db
  $row = findUserByEmail($email);
  //if ($row['username'] == $username) { array_push($errors, "Tên người dùng đã tồn tại"); }
  // check exited email in db
  if ($row['email'] == $email) { array_push($errors, "Email đã tồn tại"); }

  if (empty($password)) { array_push($errors, "Mật khẩu là bắt buộc"); }
  if ($password != $password_retype) { array_push($errors, "Mật khẩu nhập lại không chính xác"); }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    register_user($username, $email, $password);
    $info = "Vui lòng kiểm tra email để kích hoạt tài khoản của bạn.";
  }
}

// LOGIN USER
if (isset($_POST['login_user']))
{
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email)) {
    array_push($errors, "Email là bắt buộc");
  }
  if (empty($password)) {
    array_push($errors, "Mật khẩu là bắt buộc");
  }

  if (count($errors) == 0) {
    login_user($email, $password);
  }
}

// CHANGE USER PASSWORD
if (isset($_POST['change_user_password']))
{
  $old_password = $_POST['old_passowrd'];
  $password = $_POST['password'];
  $password_retype = $_POST['password_retype'];

  if (empty($old_password)) {
    array_push($errors, "Mật khẩu cũ là bắt buộc");
  }
  if (empty($password)) {
    array_push($errors, "Mật khẩu mới là bắt buộc");
  }
  if (empty($password_retype)) {
    array_push($errors, "Xác nhận mật khẩu mới là bắt buộc");
  }

  if (count($errors) == 0) {
    change_password($old_password, $password, $password_retype);
  }
}

// UPDATE USER PROFILE
if (isset($_POST['update_user_profile']))
{
  $username = $_POST['username'];
  $fullname = $_POST['fullname'];
  $mobilenumber = $_POST['mobilenumber'];
  $pfp = null;
  $pfpType = null;
  if ($_FILES['uploadpfp']['size'] > 0) {
    $pfp = upload_image($_FILES['uploadpfp']);
    $pfpType = strtolower(pathinfo($_FILES['uploadpfp']["name"], PATHINFO_EXTENSION));
  }

  if (empty($username)) {
    array_push($errors, "Tên người dùng không được để trống");
  }

  if (count($errors) == 0) {
    update_profile($_SESSION['profileID'], $username, $fullname, $mobilenumber, $pfp, $pfpType);
  }
}

//POST THE STATUS
if (isset($_POST['post_the_status']))
{
  $content = $_POST['content'];
  $visibility = $_POST['privacy'];
  $img = null;
  $imgType = null;
  if ($_FILES['postimg']['size'] > 0) {
    $img = upload_image($_FILES['postimg']);
    $imgType = strtolower(pathinfo($_FILES['postimg']["name"], PATHINFO_EXTENSION));
  }

  if (empty($content) && $img == null) {
    array_push($errors, "Không có gì để đăng!");
  }

  if (count($errors) == 0) {
    post_status($_SESSION['profileID'], $content, $img, $imgType, $visibility);
  }
}

//FORGOT PASSWORD
if (isset($_POST['forgot_password']))
{
  $email = $_POST['email'];

  if (empty($email)) {
    array_push($errors, "Email là bắt buộc");
  }

  if (count($errors) == 0) {
    if (forgotPassword($email) == true) {
      $info = "Mã xác nhận đã được gửi đến email của bạn.";
    }
    else {
      array_push($errors, "Xác nhận mật khẩu mới không chính xác!");
    }
  }
}

//RESET USER PASSWORD
if (isset($_POST['reset_user_password']))
{
  $profileID = $_SESSION['resetPasswordID'];
  $password = $_POST['password'];
  $password_retype = $_POST['password_retype'];

  if (empty($profileID)) {
    array_push($errors, "Không tìm thấy tài khoản");
  }

  if (empty($password)) {
    array_push($errors, "Mật khẩu mới là bắt buộc");
  }

  if (empty($password_retype)) {
    array_push($errors, "Xác nhận mật khẩu mới là bắt buộc");
  }

  if ($password != $password_retype) {
    array_push($errors, "Xác nhận mật khẩu mới không chính xác!");
  }

  if (count($errors) == 0) {
    unset($_SESSION['resetPasswordID']);
    resetPassword($profileID, $password, $password_retype);
    $info = "Thay đổi mật khẩu thành công.";
  }
}

//CHANGE POST PRIVACY
if (isset($_POST['privacyvalue']))
{
  $postid = $_POST['postid'];
  $privacy = $_POST['privacyvalue'];
  $post = findPostByID($postid);
  if ($post["profileID"] == $currentUser["profileID"])
  {
    setVisibility($postid, $privacy);
  }
}

//ACCEPT FRIEND REQUEST
if (isset($_POST['acceptFriendRequest']))
{
  $friendID = $_POST['acceptFriendRequest'];
  acceptFriendRequest($friendID, $currentUser["profileID"]);
  header('Location: personalpage.php?id='.$friendID);
}

?>