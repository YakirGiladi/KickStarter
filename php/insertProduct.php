<?php
	session_start();

	$conn= new mysqli("localhost",  "power.bi", "Wono7981", "kickstarter");
	
	// Check connection
	if($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}

	// prepare and bind
	$stmt= $conn->prepare("INSERT INTO projects(name, owner, shortBlurb, start_date, end_date, target, description, picture, video) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('sisssisss', $name, $owner, $shortBlurb, $start_date, $end_date, $target, $desc, $picture, $video);

	// set parameters and execute
	$name = $_POST["title"];
	$shortBlurb = $_POST["shortBlurb"];
	$owner = $_SESSION['user_id'];
	$start_date = date("Y-m-d H:i:s");

	$dateArr = explode("/", $_POST["date"]);
	$day = $dateArr[0];
	$month = $dateArr[1];
	$year = $dateArr[2];

	$end_date = $year."-".$month."-".$day;
	$target = $_POST["targetPrice"];
	$desc = $_POST["projectDesc"];
	
	$selected_radio = $_POST['videoRB'];
	echo $selected_radio;
	//exit;
	
	if ($selected_radio == 'YouTubeVideoRB') {
		$video= "http://www.youtube.com/embed/".explode("=", $_POST["YouTubeVideo"])[1];
	}
	else {
		// Upload Video
		echo "<BR>";
		echo $_FILES["FileVideo"]["type"];
		if ($_FILES["FileVideo"]["error"] == UPLOAD_ERR_OK) {
			if (($_FILES["FileVideo"]["type"] == "video/mp4") && ($_FILES["FileVideo"]["size"] < 2000000) ) {
				move_uploaded_file($_FILES["FileVideo"]["tmp_name"], "../videos/" . $_FILES["FileVideo"]["name"]);
				$video = "videos/"  . $_FILES["FileVideo"]["name"];
			}
			else {
				echo "Invalid file";
				$msg = "Invalid file";
				exit;
			}
		}
		else if($_FILES["FileVideo"]["error"] != UPLOAD_ERR_NO_FILE)
			$errorFlag = True;
	}
	
	echo "<BR>";
	echo $video;

	// Image
	if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
		if ((($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") 
		|| ($_FILES["image"]["type"] == "image/jpg")|| ($_FILES["image"]["type"] == "image/pjpeg")
		|| ($_FILES["image"]["type"] == "image/x-png")|| ($_FILES["image"]["type"] == "image/png"))
		&& ($_FILES["image"]["size"] < 2000000)) {
			move_uploaded_file($_FILES["image"]["tmp_name"], "../images/" . $_FILES["image"]["name"]);		
			$picture = "images/"  . $_FILES["image"]["name"];
		}
		else {
			$msg = "Invalid file";
			exit;
		}
	}
	else if($_FILES["image"]["error"] != UPLOAD_ERR_NO_FILE)
		$errorFlag = True;

	$stmt->execute();


	$projId = mysqli_insert_id($conn);

	// prepare and bind
	$stmt= $conn->prepare("INSERT INTO rewards(projectId, minimumDonation, maxReward, desctiption) VALUES(?, ?, ?, ?)");
	$stmt->bind_param('iiis', $projectId, $minimumDonation, $maxReward, $desctiption);

	foreach ($_POST["reward_minDonation"] as $key => $value) {
		$projectId = $projId;
		$minimumDonation = $_POST["reward_minDonation"][$key];
		$maxReward = $_POST["reward_limitBackers"][$key];
		$desctiption = $_POST["reward_desc"][$key];

		$stmt->execute();
	}

	// Add another reward for no limit
	$projectId = $projId;
	$minimumDonation = 1;
	$maxReward = -1;
	$desctiption = "money";
	
	$stmt->execute();


	$stmt->close();
	$conn->close();
	
	$msg = "The Project \'". $name . "\' was sucssesfuly created";
?>


<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script>
			$(document).ready(function() {
				$("#insertForm").submit();
			});
		</script>
	</head>
	<body>
		<form id="insertForm" method="post" action="../manageProject.php">
			<input type="hidden" name="msg" value=<?php echo "\"".$msg."\"" ?>/>
		</form>
	</body>
</html>



