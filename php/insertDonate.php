<?php

    $conn= new mysqli("localhost",  "power.bi", "Wono7981", "kickstarter");
	
	// Check connection
	if($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}

	// prepare and bind
	$stmt= $conn->prepare("INSERT INTO actions(projectId, userId, ammont, rewardId) VALUES(?, ?, ?, ?)");
	$stmt->bind_param('iiii', $projectId, $userId, $ammont, $rewardId);

	// get data from client
	$jsonObject=$_POST['data'];

	// set parameters and execute
	$projectId = $jsonObject["projectid"];
	$userId    = $jsonObject["user_id"];
	$ammont    = $jsonObject["donation"];
	$rewardId  = $jsonObject["rewardId"];
	
	
	$stmt->execute();

	$stmt->close();
	$conn->close();
	echo   "New records created successfully";
?>



