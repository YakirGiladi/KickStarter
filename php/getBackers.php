<?php
	$servername = "localhost";
	$username =  "power.bi";
	$password = "Wono7981";
	$dbname = "kickstarter";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$withFillter = isset($_POST["fillter"]) ? $_POST["fillter"] : 'false';
	
	// Get Project data from DB
	if($withFillter === 'true') {
			$sql = "SELECT tempAction.actionid as actionid, users.name, email, tempProject.name as projectName, tempAction.ammont as Donate, tempReward.desctiption FROM users, ". 
				   "(SELECT id as actionid, userId, ammont, rewardId FROM actions WHERE projectId=" . $_POST["id"] . ") as tempAction, ".
				   "(SELECT id as rewardid, projectId, desctiption FROM rewards WHERE projectId=" . $_POST["id"] . ") as tempReward, ".
				   "(SELECT id as projectid, name FROM projects WHERE id=" . $_POST["id"] . ") as tempProject ".
				    "WHERE id = tempAction.userId AND tempAction.rewardId= tempReward.rewardid AND tempProject.projectid = tempReward.projectId";
	}
	else {
			$sql = "SELECT tempAction.actionid as actionid, users.name, email, tempProject.name as projectName, tempAction.ammont as Donate,tempReward.desctiption FROM users, ". 
				   "(SELECT id as actionid, userId, ammont, rewardId FROM actions) as tempAction, ".
				   "(SELECT id as rewardid, projectId, desctiption FROM rewards) as tempReward, ".
				   "(SELECT id as projectid, name FROM projects) as tempProject ".
				    "WHERE id = tempAction.userId AND tempAction.rewardId = tempReward.rewardid AND tempProject.projectid = tempReward.projectId";
	}
	
	$backers = array();
	$result = $conn->query($sql);
	if ( $result === FALSE ) {
		echo 'error on query';
		exit;
	}
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$bus = array(
					'actionid' 	=> $row['actionid'],
					'name' 		=> $row['name'],
					'donate' 	  	=> $row['Donate'],
					'desctiption' 	=> $row['desctiption'],
					'email' 	  	=> $row['email'],
					'projectName' 	=> $row['projectName']
			);
	
			array_push($backers, $bus);
		}		
	}
	
		

	$jsonstring = json_encode($backers);
	echo $jsonstring;


	$conn->close();
?>