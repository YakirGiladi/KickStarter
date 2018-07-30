<?php
	session_start();

	$conn= new mysqli("localhost",  "power.bi", "Wono7981", "kickstarter");
	
	// Check connection
	if($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}

	// prepare and bind
	$stmt= $conn->prepare("UPDATE projects SET active=0 WHERE id=?");
	$stmt->bind_param('i', $id);

	// set parameters and execute
	$id = $_POST["projectId"];

	$stmt->execute();

	$stmt->close();
	$conn->close();

	$msg = "The Project \'". $_POST["projectName"] . "\' was sucssesfuly deleted";
?>

<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script>
			$(document).ready(function() {
				$("#delForm").submit();
			});
		</script>
	</head>
	<body>
		<form id="delForm" method="post" action="../manageProject.php">
			<input type="hidden" name="msg" value=<?php echo "\"".$msg."\"" ?>/>
		</form>
	</body>
</html>

