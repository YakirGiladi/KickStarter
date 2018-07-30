<?php
 
	session_start();
	 
	// Test the session to see if is_auth flag was set (meaning they logged in successfully)
	// If test fails, send the user to login.php and prevent rest of page being shown.
	$link = isset($_GET["link"]) ? $_GET["link"] : 'index.php';
	
	if (!isset($_SESSION["is_auth"])) {
		header("location: ../".$link);
		exit;
	}
	else {
		unset($_SESSION['is_auth']);
		session_destroy();
	 
		// After logout, send them back to login.php
		header("location: ../".$link);
		exit;
	}
 
?>
