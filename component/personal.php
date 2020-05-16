<?php
if($_POST['editpersonal']){
	$email = $_POST['mailpol'];
	$strana = $_POST['strananame'];
	$phone = $_POST['phone'];
	$data = $_POST['data'];
	$pol = $_POST['state'];
    $passwordname = md5($_POST['passwordpolsovatel']);
    
	if($email != '' && $email != ' '){
		$result = $mysqli->query("UPDATE ".POLSOVATEL." SET `email` = '$email' WHERE ".POLSOVATEL.".`id` = ".$_GET['id']);
	}
    
    if($strana != '' && $strana != ' '){
		$result = $mysqli->query("UPDATE ".POLSOVATEL." SET `strana` = '$strana' WHERE ".POLSOVATEL.".`id` = ".$_GET['id']);
	}
    
    if($phone != '' && $phone != ' '){
		$result = $mysqli->query("UPDATE ".POLSOVATEL." SET `phone` = '$phone' WHERE ".POLSOVATEL.".`id` = ".$_GET['id']);
	}
    
    if($data != '' && $data != ' '){
		$result = $mysqli->query("UPDATE ".POLSOVATEL." SET `data` = '$data' WHERE ".POLSOVATEL.".`id` = ".$_GET['id']);
	}
    
    if($pol != '' && $pol != ' '){
		$result = $mysqli->query("UPDATE ".POLSOVATEL." SET `state` = '$pol' WHERE ".POLSOVATEL.".`id` = ".$_GET['id']);
	}
    
    if($_POST['passwordpolsovatel'] != '' && $_POST['passwordpolsovatel'] != ' '){
		$result = $mysqli->query("UPDATE ".POLSOVATEL." SET `password` = '$passwordname' WHERE ".POLSOVATEL.".`id` = ".$_GET['id']);
		session_destroy();
		unset($_GET, $_POST);
		header('Location: http://iridoc.com/cardio/index.php');
	}
}

echo PersonalData($_SESSION);
