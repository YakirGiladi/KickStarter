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
	
	
	// Get Project data from DB
	$sql = "SELECT * FROM projects WHERE id = " . $_POST["id"] . " LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		
		$name = $row['name'];
		$shortBlurb = $row['shortBlurb'];
		$ownerId = $row['owner'];
		$end_date = $row['end_date'];
		$gathered = $row['gathered'];
		$target = $row['target'];
		$description = $row['description'];
		$picture = $row['picture'];
		$video = $row['video'];
	}
	
	
	// Get User data from DB
	$sql = "SELECT COUNT(projectId) AS backers FROM actions WHERE projectId =" . $_POST["id"] . " GROUP BY projectId LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		
		$backers = $row['backers'];
	}
	else
		$backers = 0;
	
	
	// Get Rewards data from DB
	$rewards = array();
	$sql = 	" SELECT rewards.id, minimumDonation, maxReward, desctiption, backers" .
			" FROM rewards".
			" WHERE active=1 AND rewards.projectId = ".$_POST["id"].
			" ORDER BY minimumDonation";
	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$bus = array(
				'rewardId' => $row['id'],
				'minimumDonation' => $row['minimumDonation'],
				'maxReward' => $row['maxReward'],
				'desctiption' => $row['desctiption'],
				'rewardBackers' => $row['backers']
			);
			
			array_push($rewards, $bus);
		}
	}
	
	
	// Get User data from DB
	$sql = "SELECT name FROM users WHERE id = " . $ownerId . " LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
	
		$owner = $row['name'];
	}
	
	
	// Gather all the data
	$json = array(
			'name' => $name,
			'shortBlurb' => $shortBlurb,
			'end_date' =>   $end_date,
			'gathered' => $gathered,
			'target' =>   $target,
			'description' =>   $description,
			'picture' =>   $picture,
			'video' =>   $video,
			'owner' => $owner,
			'backers' => $backers,
			'rewards' => $rewards
	);
	
	$jsonstring = json_encode($json);
	echo $jsonstring;


	$conn->close();
?>




