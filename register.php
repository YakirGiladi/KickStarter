<!DOCTYPE html>
<?php session_start(); ?>
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
<script src="js/register_functions.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- Poster -->
<link href="css/poster.css" rel="stylesheet">

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

	    if(userType != -1)
	    {
			var title = "<h3><b><center>Kickstarter Warning</center></b></h3>";
			var body = "<p>You are logged in!</p>";
			setButton_onClick('window.location.replace("index.php")');
			showModal(title, body);
        }
	    else 
	    	onLogOut("register.php");
		    
	});
</script>

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

<body>

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
				<a class="navbar-brand" href="index.php">Home</a>
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


	<div class="jumbotron">
		<div class="container" style="margin-bottom: -20px;">
			<h1><center>Kickstarter Registration</center></h1>
			<p> </p>
		</div>
	</div>

	<div class="container">
		<!-- Project Container -->
		<div class="container-fluid">
		    <section class="container">
				<div class="container-page">				
					<div class="col-md-6">				
						<div class="form-group col-lg-12">
							<label>Name</label>
							<input id="Name" type="text" class="form-control not-null-value" value="">
						</div>
						
						<div class="form-group col-lg-6">
							<label>Password</label>
							<input id="Password" type="password" name="" class="form-control password pass1 not-null-value" value="">
						</div>
						
						<div class="form-group col-lg-6">
							<label>Repeat Password</label>
							<input id="RepeatPassword" type="password" name="" class="form-control password pass2 not-null-value" value="">
						</div>
										
						<div class="form-group col-lg-6">
							<label>Email Address</label>
							<input id="EmailAddress" type="email" name="" class="form-control email email1 not-null-value" value="">
						</div>
						
						<div class="form-group col-lg-6">
							<label>Repeat Email Address</label>
							<input id="RepeatEmailAddress" type="email" name="" class="form-control email email2 not-null-value" value="">
						</div>
						
						<div class="form-group col-lg-6">
							<label>Customer Type</label>
							<select class="form-control" id="CustomerType">
							    <option>Regular</option>
							    <option>Promoter</option>
							</select>
						</div>
					</div>
				
					<div class="col-md-6">
						<h3 class="dark-grey">Terms and Conditions</h3>
						<p>
							By clicking on "Register" you agree to The Company's' Terms and Conditions
						</p>
						<p>
							While rare, prices are subject to change based on exchange rate fluctuations - 
							should such a fluctuation happen, we may request an additional payment. You have the option to request a full refund or to pay the new price. (Paragraph 13.5.8)
						</p>
						<p>
							Should there be an error in the description or pricing of a product, we will provide you with a full refund (Paragraph 13.5.6)
						</p>
						<p>
							Acceptance of an order by us is dependent on our suppliers ability to provide the product. (Paragraph 13.5.6)
						</p>
						
						<button id="submit" type="submit" class="btn btn-primary" onclick="validation()">Register</button>
					</div>
				</div>
			</section>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog"></div>
		
		<hr>
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
