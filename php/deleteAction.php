<?php
	session_start();

	$conn= new mysqli("localhost",  "power.bi", "Wono7981", "kickstarter");
	
	// Check connection
	if($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}

	// prepare and bind
	$stmt= $conn->prepare("DELETE FROM actions WHERE id=?");
	$stmt->bind_param('i', $id);

	// set parameters and execute
	$id = $_POST["actionId"];

	$stmt->execute();

	$stmt->close();
	$conn->close();

	echo "The record was deleted successfully";
?>



