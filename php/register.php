
<?php
 	session_start();
 	
 	// Get data from client
 	$jsonObject=$_POST['data'];
 	
	//init a connection
	$conn= new mysqli("localhost", "power.bi", "Wono7981", "kickstarter");
	
	// Check connection
	if($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}
	
	// Check if user exist
	$sql = "SELECT id FROM users WHERE email='". $jsonObject["email"] . "' LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "Email is all ready in use, please choose another email";
	}
	else {
		
		// Encrypt the password
		$sourceStr= $jsonObject["password"];
		$sourceStr=$sourceStr[0].$sourceStr.$sourceStr[0];
		$jsonObject["password"]=md5($sourceStr);
	
		// Get typeId
		$sql = "SELECT id FROM usertype WHERE type='". $jsonObject["type"] . "' LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$typeId = $row['id'];
		}
		
		// insert user
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
	
		$_SESSION['is_auth'] = $typeId;
	    $_SESSION['user_id'] = $userId;
	    $_SESSION['name']    = $name;
	    $_SESSION['email']   = $email;
	
	    echo 1;
	}
?>



