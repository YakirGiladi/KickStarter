
<?php
 	include 'cookie.php';
	// get data from client
	$jsonObject=$_POST['data'];

	//encrypt the password
	$sourceStr= $jsonObject["password"];
	$sourceStr=$sourceStr[0].$sourceStr.$sourceStr[0];
	$jsonObject["password"]=md5($sourceStr);
	
	//init a connection
	$conn= new mysqli("localhost",  "power.bi", "Wono7981", "kickstarter");
	
	// Check connection
	if($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}

	// get typeId
	$sql = "SELECT id FROM usertype WHERE type='". $jsonObject["type"] . "' LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$typeId = $row['id'];
	}
	
	// prepare and bind
	$stmt= $conn->prepare("INSERT INTO users(name, email, password, type) VALUES(?, ?, ?, ?)");
	$stmt->bind_param('sssi', $name, $email, $password, $type);

	// set parameters and execute
	$name = $jsonObject["name"];
	$email = $jsonObject["email"];
	$password   = $jsonObject["password"];
	$type = $typeId;

	$stmt->execute();

	// get userId
	$sql = "SELECT id FROM users WHERE email='". $email . "' LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$userId = $row['id'];
	}

	$stmt->close();
	$conn->close();



	$userDetails = array(
		"name" => $name,
		"email" => $email,
		"type" => $typeId
	);
	$jsonstring = json_encode($userDetails);

	setCookies($jsonstring);

	echo   1;
	
?>



