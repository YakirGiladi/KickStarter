<?php

    $conn= new mysqli("localhost",  "power.bi", "Wono7981", "kickstarter");
	
	// Check connection
	if($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}

	// prepare and bind
	$stmt= $conn->prepare("INSERT INTO projects(name, start_date, end_date, target, description, picture, video) VALUES(?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('sssisss', $name, $start_date, $end_date, $target, $desc, $picture, $video);

	// get data from client
	$jsonObject=$_POST['data'];

	// set parameters and execute
	$name = $jsonObject["name"];
	$start_date = $jsonObject["start_date"];
	$end_date   = $jsonObject["end_date"];
	$target = $jsonObject["target"];
	$desc = $jsonObject["desc"];
	$picture = $jsonObject["picture"];
	$video = $jsonObject["video"];

	$stmt->execute();

	$stmt->close();
	$conn->close();
	echo   "New records created successfully";
	
?>



