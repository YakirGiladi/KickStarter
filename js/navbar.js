var loginLink;

function onLogIn(userName, link) {
	loginLink = link;
	$('.navbar-right').html(' <div class="userAccount form-group disable" style="color: white;margin-right: 27px;"> Welcome ' + userName + ' :-)</div>' +
                          	' <a href="php/logout.php?link='+link+'" id="logoutBtn" class="btn btn-success"><span class="glyphicon glyphicon-user"></span>  Log Out</a>');
	
	if(userType==2) { // Promoter user
		$('.navbar-right').append('	<div class="dropdown form-group">'+
									  	'<button class="btn btn-success dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">My Account'+
									    '<span class="caret"></span></button>'+ 
									    '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">'+ 
									    	'<li role="presentation">' +
												'<form id="navabarForm" method="post" action="projectForm.php">' +
													'<input type="hidden" name="projectId" value="-1"/>' +
													'<a role="menuitem" tabindex="-1" onclick="document.getElementById(\'navabarForm\').submit();" style="cursor: pointer;">Start a Project</a>' +
												'</form>' +
								    		'</li>'+ 
								    		'<li role="presentation"><a role="menuitem" tabindex="-1" href="manageProject.php">My Projects</a></li>'+ 
									    	'<li role="presentation" class="divider"></li>'+ 
									    	'<li role="presentation"><a role="menuitem" tabindex="-1" onclick="showAboutBox()">About</a></li>'+ 
									    '</ul>'+ 
								  	'</div>');
	}
	
	if(userType==3) { // Admin user
		$('.navbar-right').append('	<div class="dropdown form-group">'+
									  	'<button class="btn btn-success dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">My Account'+
									    '<span class="caret"></span></button>'+ 
									    '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">'+ 
									    	'<li role="presentation">' +
												'<form id="createProjectForm" method="post" action="projectForm.php">' +
													'<input type="hidden" name="projectId" value="-1"/>' +
													'<a role="menuitem" tabindex="-1" onclick="document.getElementById(\'createProjectForm\').submit();" style="cursor: pointer;">Start a Project</a>' +
												'</form>' +
								    		'</li>'+ 
								    		'<li role="presentation"><a role="menuitem" tabindex="-1" href="manageProject.php">Mannage All Projects</a></li>'+
								    		'<li role="presentation"><a role="menuitem" tabindex="-1" href="manageBackers.php">Mannage All Backers</a></li>'+
									    	'<li role="presentation" class="divider"></li>'+ 
									    	'<li role="presentation"><a role="menuitem" tabindex="-1" onclick="showAboutBox()">About</a></li>'+ 
									    '</ul>'+ 
								  	'</div>');
	}
}


function onLogOut(link) {
	loginLink = link;
	$('.navbar-right').html(	'<div class="form-group" style="margin-right: 3px;">' +
									'<input type="email" id="logInEmail" placeholder="Email" class="form-control">' +
								'</div>' +
								'<div class="form-group" style="margin-right: 3px;">' +
									'<input type="password" id="logInPassword" placeholder="Password" class="form-control">' +
								'</div>' +
								'<button type="submit" class="btn btn-success" style="margin-right: 2px;">Sign in</button>' +
								'<a href="register.php" class="btn btn-success">Register</a>');
}

$(document).ready(function() {
	$('#searchbox').click(function() {
		return false;
	});

	$('#searchbox').keypress(function() {
		$('.searchBoxDropdown').addClass("open");
		$('.searchBoxDropdown').removeClass("close");
	});
});


function drawNavbar() {
	var navbar = 	'<div class="container">' +
						'<div class="navbar-header">' +
							'<button type="button" class="navbar-toggle collapsed"' +
								'data-toggle="collapse" data-target="#navbar" aria-expanded="false"' +
								'aria-controls="navbar">' +
								'<span class="sr-only">Toggle navigation</span>' +
								'<span class="icon-bar"></span>' +
							 	'<span class="icon-bar"></span>' +
								'<span class="icon-bar"></span>' +
							'</button>' +
							'<a class="navbar-brand" href="#">Home</a>' +
						'</div>' +

						'<div class="nav navbar-nav navbar-form">' +
							'<div ng-app="myApp" ng-controller="searchCtrl">' +
								'<div class="form-group col-md-12">' +
									'<div class="searchBoxDropdown input-group col-md-12" style="padding-left: 20px; padding-right: 20px; width:150%;">' +
										'<input type="text" ng-model="test" placeholder="Find what interests you most..." id="searchbox" class="form-control dropdown-toggle" data-toggle="dropdown" />' +
										'<span class="input-group-btn">' +
					                        '<button class="btn btn-info searchBT" style="border-radius: 4px; margin-left: 0px; cursor: default;">' +
					                            '<i class="glyphicon glyphicon-search"></i>' +
					                        '</button>' +
					                    '</span>' +
										'<ul class="dropdown-menu col-md-9" style="padding: 2px; margin-left: 20px;">' +
											'<li ng-repeat="x in names | filter:test" style="padding-bottom: 2px;">' +
												'<a class="well searchDiv" href={{getURL(x.id)}} style="padding: 5px; margin: 0px;">' +
													'<img width="50px" src={{x.picture}} /> {{x.name}}' +
												'</a>' +
											'</li>' +
										'</ul>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>' +

						'<div id="navbar" class="navbar-collapse collapse" style="margin-left:25%">' +
							'<form class="navbar-form navbar-right">' +
								'<div class="form-group">' +
									'<input type="email" id="logInEmail" placeholder="Email" class="form-control">' +
								'</div>' +
								'<div class="form-group">' +
									'<input type="password" id="logInPassword" placeholder="Password" class="form-control">' +
								'</div>' +
								'<button type="submit" class="btn btn-success">Sign in</button>' +
								'<a href="register.html" class="btn btn-success">Register</a>' +
							'</form>' +

						'</div>' +
					'</div>';
	$("#navBar").append(navbar);
}

$(document).ready(function() {
	$('.navbar-right').submit(function(ev) {
	    ev.preventDefault();
	    submitLogIn();
	});
});


function submitLogIn() {

	var myJsonObject = {
			"email" : $("#logInEmail").val(),
			"password" : $("#logInPassword").val()
	}
			
	$.post("php/logIn.php", {data: myJsonObject},
		function (data, textStatus) {
			
			if(data != 1) {
				// Alart
				
				var title = "<h3><b><center>Kickstarter Warnning</center></b></h3>";
				var body = "<p>"+data+"</p>";
				showModal(title, body);
			}
			else {
				window.location.replace(loginLink);
			}
		}
	);
}


function showAboutBox() {
	var title = "<h3><b><center>About</center></b></h3>";
	var box = "<p>This is a project for Internet Technologies in Afeka College, made by Yakir&trade; & Nir&trade;</p>";
	showModal(title, box);
}

