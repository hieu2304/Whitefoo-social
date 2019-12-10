<?php  
	require_once 'init.php';
	 if (!$currentUser) {
	 	header('Location : index.php');
	 	exit();
	 }
	 $userID = $_POST['profileID'];
	 $profileID = findUserByID($userID);
	 sendFriendRequest($currentUser['profileID'], $userID);
	 header('Location: personalpage.php?id='.$_POST['profileID']);
?>