<!DOCTYPE html>
<?php
session_start ();
?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">

<title>Home</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/custom.css" rel="stylesheet">

<!-- Jquery core CSS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.form.min.js"></script>

<!-- datepicker -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>


<!-- projectForm -->
<script src="js/projectForm_functions.js"></script>
<script>
	$(document).ready(function() { 
	    var projectId = <?php echo $_POST["projectId"]; ?>;
		fillFormData(projectId);
		addReward("","","1");
	});
</script>
<style type="text/css">
#eventForm .form-control-feedback {
	top: 0;
	right: -15px;
}
</style>

<!-- Navbar -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/modal.js"></script>
<link href="css/navbar.css" rel="stylesheet">
<script>
	var userName;
	var user_id;
	var userType;
	
	var app = angular.module('myApp', []);
	app.controller('searchCtrl', function($scope, $http) {
		$http.get("php/getProjects.php").success(function(response) {
			$scope.names = response;
			$scope.getURL = function(id) {
				return "project.php?id=" + id;
			}
		});
	});

	$(document).ready(function() {
		userType = <?php  echo isset($_SESSION['is_auth']) ? $_SESSION['is_auth'] : -1; ?>;
		userName = <?php echo isset($_SESSION['name']) ? "'".$_SESSION['name']."'" : "''" ?>;
		user_id= <?php  echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; ?>;

		var link = "index.php";
        if( userType == 2 || userType == 3  )
             onLogIn(userName, link);
        else {
          	$('#body').html("");
          	alert("You are not autohirze");
            window.location.assign(link);
        }
	});
</script>

<style>
body {
	position: relative;
}

ul.nav-pills {
	top: 20%;
	position: fixed;
}

div.col-sm-9 div {
	height: 250px;
	font-size: 28px;
}
</style>

<!-- Custom styles for this template 
    <link href="jumbotron.css" rel="stylesheet">-->

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="body" data-spy="scroll" data-target="#myScrollspy" data-offset="20">

	<!-- Navbar -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
		
			<!-- Navbar Header -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
				 	<span class="icon-bar"></span> 
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">Kickstarter Project</a>
			</div>

			<!-- Navbar Search Area -->
			<div class="nav navbar-nav navbar-form">
				<div ng-app="myApp" ng-controller="searchCtrl">
					<div class="form-group col-md-12">
						<div class="searchBoxDropdown input-group col-md-12" style="padding-left: 20px; padding-right: 20px; width:150%;">
							<input type="text" ng-model="test" placeholder="Find what interests you most..." id="searchbox" class="form-control dropdown-toggle" data-toggle="dropdown" />
							<span class="input-group-btn">
		                        <button class="btn btn-info searchBT" style="border-radius: 4px; margin-left: 0px; cursor: default;">
		                            <i class="glyphicon glyphicon-search"></i>
		                        </button>
		                    </span>
							<ul class="dropdown-menu col-md-9" style="padding: 2px; margin-left: 20px;">
								<li ng-repeat="x in names | filter:test" style="padding-bottom: 2px;">
									<a class="well searchDiv" href={{getURL(x.id)}} style="padding: 5px; margin: 0px;">
										<img width="50px" src={{x.picture}} /> {{x.name}}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Navbar Right  -->
			<div id="navbar" class="navbar-collapse collapse" >
				<form class="navbar-form navbar-right"></form>
			</div>
			
		</div>
	</nav>


	<!-- Main jumbotron for a primary marketing message or call to action -->
	<div id="title" class="jumbotron">
		<div class="container">
			
			<!-- Page Title -->
			<div class="col-md-12 text-center" style="margin-top: 20px;">
				<h1 id="FormTitle">Project Creator</h1>
				<p>(-: Lets get your project going :-)</p>
				<p> ~ Give us the details we need ~ </p>
			</div>
			
			<!-- Main Container -->
			<div class="col-md-12" style="margin-top: 30px;">
			
				<!-- Left Navigator -->
				<nav class="col-sm-3" id="myScrollspy">
					<ul class="nav nav-pills nav-stacked"
						style="font-size: 19px; left: 6%;">
						<li class="active"><a href="#title">Project Name</a></li>
						<li><a href="#ShortBlurb">Summary</a></li>
						<li><a href="#image">Project Poster</a></li>
						<li><a href="#video">Project Video</a></li>
						<li><a href="#date">Raise Period</a></li>
						<li><a href="#targetPrice">Raise Goal</a></li>
						<li><a href="#Rewards">Rewards</a></li>
						<li><a href="#description">Project Description</a></li>
						<li><a href="#SubmitFinal">Finish</a></li>
					</ul>
				</nav>


				<!-- Form Container -->
				<div class="col-md-10" style="float: none; margin: -35px auto;">
					<div class="panel panel-default" style="margin: 50px;">
						<div class="panel-body">
							<form id="productForm" action="php/insertProduct.php" method="post" enctype="multipart/form-data">
								
								<!--Project id -->
								<input type="hidden" name="projectId" value="<?php echo $_POST["projectId"]; ?>"/>
								
								<!--Project Name -->
								<div id="ShortBlurb" class="jumbotron">
									<div class="container">
										<div class="col-md-12">
											<div class="col-md-3">
												<h5>
													<b>Project Name</b>
												</h5>
											</div>
											<div class="col-md-9">
												<input id="title_input" name="title" type="text" class="form-control"> <br>
											</div>
										</div>
									</div>
								</div>


								<!--Summary -->
								<div id="image" class="jumbotron">
									<div class="container">
										<div class="col-md-12">
											<div class="col-md-3">
												<h5>
													<b>Summary</b>
												</h5>
											</div>
											<div class="col-md-9">
												<textarea id="shortBlurb_input" class="form-control" name="shortBlurb" rows="5" maxlength="135" style="width: 100%;"></textarea>
												<br>
											</div>
										</div>
									</div>
								</div>


								<!--Project Poster -->
								<div id="video" class="jumbotron">
									<div class="container">
										<div class="col-md-12">
											<div class="col-md-3">
												<h5>
													<b>Project Poster </b>
												</h5>
											</div>
											<div class="col-md-9">
												<img id="displayImg" class="img-thumbnail" alt="image" width="100%" src="img/no_image.png">
												<input id="file_image" class="form-control" type="file" accept="image/*" name="image" />
											</div>
										</div>
									</div>
								</div>

								<!--Project video -->
								<div id="date" class="jumbotron">
									<div class="container">
										<div class="col-md-12">
											<div class="col-md-3">
												<h5>
													<b>Project video</b>
												</h5>
											</div>
											<div class="col-md-9">
											    <div class="radio">
											    	<label><input id="URLVideoRB" type="radio" name="videoRB" value="YouTubeVideoRB" checked>URL from YouTube</label>
											    	<input id="URL_Video" class="form-control" name="YouTubeVideo" type="text">
											    </div>
											    <div class="radio">
											    	<label><input id="uploudVideoRB" type="radio" name="videoRB" value="FileVideoRB">Upload Video</label>
											    	<input id="file_Video" class="form-control" type="file" accept="video/*" name="FileVideo" />
											    </div>
											</div>
										</div>
									</div>
								</div>

								<!--Raise Period -->
								<div id="targetPrice" class="jumbotron">
									<div class="container">
										<div class="col-md-12">
											<div class="col-md-3">
												<h5>
													<b>Raise Period</b>
												</h5>
											</div>
											<div class="col-md-9">
												<div class="form-group">
													<div class="date">
														<div class="input-group input-append date" id="datePicker">
															<input id="date_input" type="text" class="form-control" name="date" /> 
															<span class="input-group-addon add-on">
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!--Raise Goal -->
								<div id="Rewards" class="jumbotron">
									<div class="container">
										<div class="col-md-12">
											<div class="col-md-3">
												<h5>
													<b>Raise Goal</b>
												</h5>
											</div>
											<div class="col-md-9">
												<input id="target_input" class="form-control" type="number" name="targetPrice">
											</div>
										</div>
									</div>
								</div>


								<!--Rewards -->
								<div id="description" class="jumbotron">
									<div class="container">
										<div id="rewardContainer"></div>
										<!-- add button -->
										<div id="SubmitFinal" class="col-md-12">
											<div class="col-md-4"></div>
											<input class="col-md-4 btn btn-primary btn-xs"
												value="Add Reward" onclick="addReward('','','1')" type="button"
												style="height: 25px;" />
											<div class="col-md-4"></div>
										</div>
									</div>
								</div>

								<!--Project Description -->
								<div class="jumbotron">
									<div class="container">
										<div class="col-md-12">
											<div class="col-md-3">
												<h5>
													<b>Project Description</b>
												</h5>
											</div>
											<div class="col-md-9">
												<textarea id="description_input" class="check form-control" name="projectDesc" rows="10" cols="80"></textarea>
			
											</div>
										</div>
									</div>
								</div>
								<center>
									<input class="btn btn-success" type="submit" value="Finish">
								</center>

								<script>
					                // Replace the <textarea id="editor1"> with a CKEditor
					                // instance, using default configuration.
					                CKEDITOR.replace( 'description_input', {language: 'en'} );
			            		</script>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog"></div>

	<div class="container">
		<footer>
			<p>&copy; Yakir Giladi & Nir Ostrovski</p>
		</footer>
	</div>
	

	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script> -->
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug 
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    -->
</body>
</html>
