<?php
	session_start();
	
	$servername = "localhost";
	$username =  "power.bi";
	$password = "Wono7981";
	$dbname = "kickstarter";
	$json = array();
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$withFillter = isset($_POST["fillter"]) ? $_POST["fillter"] : 'false';
	if($withFillter === 'true')
		$sql = "SELECT * FROM projects WHERE active=1 AND owner=". $_SESSION['user_id'];
	else if ($withFillter === 'admin')
		$sql = "SELECT * FROM projects WHERE active=1";
	else
		$sql = "SELECT * FROM projects WHERE active=1 AND end_date>NOW()";
	
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$bus = array(
				'id' => $row['id'],
				'name' => $row['name'],
				'shortBlurb' => $row['shortBlurb'],
				'start_date' => $row['start_date'],
				'end_date' =>   $row['end_date'],
				'gathered' => $row['gathered'],
				'target' =>   $row['target'],
				'percentage' => round($row['gathered']/$row['target']*100),
				'picture' =>   $row['picture'],
				'video' => $row['video'],
				'description' => $row['description']
			);
			
			array_push($json, $bus);
		}	
	}
	
	$jsonstring = json_encode($json);
	echo $jsonstring;


	$conn->close();
?>




