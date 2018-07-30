<?php
	$jsonObject=$_POST['data'];

	if($jsonObject=="getCookie")
		getCookies();


	function getCookies() {
		if(!isset($_COOKIE["kickStarter"])) {
			echo -1;
		}
		else {
			echo  $_COOKIE["kickStarter"];
		}
	}

	function setCookies($userDetails) {

		setcookie("kickStarter", $userDetails, time() + (86400 * 30)); // 86400 = 1 day
	}


?>