<?php
	session_start();

	$conn= new mysqli("localhost",  "power.bi", "Wono7981", "kickstarter");
	
	// Check connection
	if($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}
	
	// set parameters and execute
	$name = $_POST["title"];
	$shortBlurb = $_POST["shortBlurb"];
	$owner = $_SESSION['user_id'];
	$start_date = date("Y-m-d H:i:s");
	$date_pieces = explode("/", $_POST["date"]);
	$end_date = $date_pieces[2]."-".$date_pieces[1]."-".$date_pieces[0];
	$target = $_POST["targetPrice"];
	$desc = $_POST["projectDesc"];
	
	$sql = 	"UPDATE projects SET name='".$name."', owner=".$owner.", shortBlurb='".$shortBlurb."', start_date='".$start_date."', end_date='".$end_date."', target=".$target.", description='".$desc."'";
	
	// Image
	if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
		
		// prepare and bind
		$stmt= $conn->prepare($sql);
		$stmt->bind_param('sisssisss', $name, $owner, $shortBlurb, $start_date, $end_date, $target, $desc, $video, $picture);
		
		if ((($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg")
				|| ($_FILES["image"]["type"] == "image/jpg")|| ($_FILES["image"]["type"] == "image/pjpeg")
				|| ($_FILES["image"]["type"] == "image/x-png")|| ($_FILES["image"]["type"] == "image/png"))
				&& ($_FILES["image"]["size"] < 2000000)) {
					move_uploaded_file($_FILES["image"]["tmp_name"], "../images/" . $_FILES["image"]["name"]);
					$picture = "images/"  . $_FILES["image"]["name"];
					$sql .= ", picture='".$picture."'";
				}
				else
					header('Location: ../manageProject.php?status="Invalid file"');
	}

	$selected_radio = $_POST['videoRB'];
	
	if ($selected_radio == 'YouTubeVideoRB') {
		if (strpos($_POST["YouTubeVideo"],'http://www.youtube.com/embed/') !== false)
			$video = $_POST["YouTubeVideo"];
		else
			$video= "http://www.youtube.com/embed/".explode("=", $_POST["YouTubeVideo"])[1];
		$sql .= ", video='".$video."'";
	}
	else {
		// Upload Video
		echo $_FILES["FileVideo"]["type"];
		if ($_FILES["FileVideo"]["error"] == UPLOAD_ERR_OK) {
			if (($_FILES["FileVideo"]["type"] == "video/mp4") && ($_FILES["FileVideo"]["size"] < 2000000) ) {
				move_uploaded_file($_FILES["FileVideo"]["tmp_name"], "../videos/" . $_FILES["FileVideo"]["name"]);
				$video = "videos/"  . $_FILES["FileVideo"]["name"];
				$sql .= ", video='".$video."'";
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
	
	$sql .= " where id=".$_POST["projectId"];
	if ($conn->query($sql) === TRUE)
		$msg = "The Project \'". $name . "\' was sucssesfuly updated";
	else
		$msg = "Error updating project \'". $name . "\'";


	$sql = "UPDATE rewards SET active=0 WHERE desctiption!='money' AND projectId=".$_POST["projectId"];
	if ($conn->query($sql) === TRUE)
		$msg = "The Project \'". $name . "\' was sucssesfuly updated";
	else
		$msg = "Error updating rewards of the project \'". $name . "\'";
		
		

	// prepare and bind
	$stmt= $conn->prepare("INSERT INTO rewards(projectId, minimumDonation, maxReward, desctiption) VALUES(?, ?, ?, ?)");
	$stmt->bind_param('iiis', $projectId, $minimumDonation, $maxReward, $desctiption);

	foreach ($_POST["reward_minDonation"] as $key => $value) {
		$projectId = $_POST["projectId"];
		$minimumDonation = $_POST["reward_minDonation"][$key];
		$maxReward = $_POST["reward_limitBackers"][$key];
		$desctiption = $_POST["reward_desc"][$key];

		$stmt->execute();
	}

	$stmt->close();
	$conn->close();
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

