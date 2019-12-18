<?php  
	require_once 'init.php';
	 if (!$currentUser) {
	 	header('Location : index.php');
	 	exit();
	 }
	 if(isset($_POST['unFriend']))
	 {
		$userID = $_POST['unFriend'];
		$profileID = findUserByID($userID);
		removeFriendRequest($currentUser['profileID'], $userID);
		header('Location: personalpage.php?id='.$userID);
	 }
?>