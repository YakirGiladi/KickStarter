function getProjects(userType) {
	var value = "true";
	if(userType==3)
		value = "admin";
	$.post("php/getProjects.php", {fillter: value},
			function (data, textStatus) {
				displayMainContainerProjects(JSON.parse(data), value);
			}
	);
}


function showBackers(projectId) {
	$.post("php/getBackers.php", {id: projectId, fillter:"true"},
			function (data, textStatus) {
				var jsonArr= JSON.parse(data);
				
				if(jsonArr.length == 0 ) {
					var title = "<h3><b><center>Kickstarter Warning</center></b></h3>";
					var body = "<p>There are no backers yet</p>";
					showModal(title, body);
				}
				else {
					var body = "<div class='container'>"+
								  "<div class='table-responsive' >"+
									 "<table class='table' style='width: 48%'>"+
									  	"<thead>"+
										  	"<tr>"+
										  		"<th>Name</th>"+
										        "<th>Email</th>"+
										        "<th>Pledge</th>"+
										        "<th>Desctiption</th>"+
										    "</tr>"+
									    "</thead>"+
									    "<tbody id='table_body'>"+
									    	addTableRows(jsonArr) +
									    "</tbody>"+
				 					"</table>"+
				 				  "</div>"+
							   "</div>";
					
					var header = "<b><center>Backers Information</center></b>";
					showModal(header, body);
				}
			});
}

function addTableRows(jsonArr) {
	var tbody = "";
	
	for (var i = 0 ; i <  jsonArr.length ; i++) {
		tbody +=	"<tr>"+
						"<td>"+jsonArr[i].name        +" </td>"+
						"<td>"+jsonArr[i].email 	  +" </td>"+
						"<td>"+jsonArr[i].donate 	  +" </td>"+
						"<td>"+jsonArr[i].desctiption +" </td>"+
					"</tr>";
	}
	
	return tbody;
}

function startDestTime(destDate, row) {
	// set the date we're counting down to
	var target_date = new Date(destDate).getTime();
	 
	// variables for time units
	var days, hours, minutes, seconds;
	 
	// get tag element
	var countdown = document.getElementById("countdown_" + row);
	 
	// update the tag with id "countdown" every 1 second
	setInterval(function () {
		countdown.innerHTML = getInterval(target_date);
	}, 1000);
}

function getInterval(target_date) {
	 
    // find the amount of "seconds" between now and target
    var current_date = new Date().getTime();
    var seconds_left = (target_date - current_date) / 1000;
 
    // do some time calculations
    days = parseInt(seconds_left / 86400);
    seconds_left = seconds_left % 86400;
     
    hours = parseInt(seconds_left / 3600);
    seconds_left = seconds_left % 3600;
     
    minutes = parseInt(seconds_left / 60);
    seconds = parseInt(seconds_left % 60);
    
 	// format countdown string + set tag value
    if(days == 0) {
    	if(hours == 0) {
    		if(minutes == 0) {
    			return "<span class='seconds'>" + seconds +  " Seconds</span>";
    		}
    		else {
    			return "<span class='minutes'>" + minutes +  " Minutes</span>";
    		}
    	}
    	else {
    		return "<span class='hours'>" + hours +  " Hours</span>";
    	}
    }
    else {
    	return '<span class="days">' + days + ' Days</span>';  
    }
}


function displayOneProject(json, row, value) {
	var displayProp = "";
	if(value !== "admin") {
		displayProp = "style='display: none;'";
	}
	
	//need to change to not null in database
	//var jsonStr = JSON.stringify(json);
	var url="projectForm.php";
	var box = "<div class='col-md-4' style='border-radius: 12px; padding:0px; width:29%; margin: 20px; border: solid 1px #d9d9de;'>" +
					"<img src=" + json.picture + " class='img-responsive' alt='Cinque Terre' width=100% style='max-height:200px;border-top-left-radius: 6px;border-top-right-radius: 6px;'>"+
					"<form id='projectForm_"+row+"' method='post' action='projectForm.php'>" +
						"<input type='hidden' name='projectId' value='"+json.id+"'/>" +
					"</form>" +
					"<div class='dropdown '>"+
  						"<button style='width:100%'' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Options    "+
  						"<span class='caret'></span></button>"+
  						"<ul id='menu"+row+"' class='dropdown-menu'>"+
						    "<li><a onclick='document.getElementById(\"projectForm_"+row+"\").submit();' style='cursor: pointer;'>Edit project details</li>"+
						    "<li><a style='cursor:pointer;'onclick='showBackers("+json.id+")'>Show all backers</a></li>"+
						    "<li><a href='project.php?id="+json.id+"' style='cursor:pointer;'>Show project page</a></li>"+
						    "<li "+displayProp+">"+
								"<form id='delProjectForm"+row+"' method='post' action='php/deleteProject.php'>" +
									"<input type='hidden' name='projectId' value='"+json.id+"'/>" +
									"<input type='hidden' name='projectName' value='"+json.name+"'/>" +
									"<a role='menuitem' tabindex='-1' onclick='document.getElementById(\"delProjectForm"+row+"\").submit();' style='cursor: pointer;'>Delete project</a>" +
								"</form>" +
							"</li>"+
						"</ul>"+
					"</div>"+
					"<div style=' margin-left: 15px; margin-right: 15px'>"+
					"<h2>" + json.name + "</h2>" +
					"<p style='height: 50px;'>" + json.shortBlurb + "</p>" +
					"<div class='progress' style='height: 15px; margin-top: 30px; margin-bottom: 7px;'>" +
						"<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:" + json.percentage + "\%'><span class='sr-only'>" + json.percentage + "\%</span></div>" +
					"</div>" +
					"<center><ul class='list-inline'>" +
					    "<li>" +
					    	"<div><b>" + json.percentage + "\%</b></div>" +
					    	"<div>Progress</div>" +
					    "</li>" +
					    "<li style='list-style: none'>|</li>" +
					    "<li>" +
					    	"<div><b>$" + json.gathered + "</b></div>" +
					    	"<div>Raised</div>" +
				    	"</li>" +
					    "<li style='list-style: none'>|</li>" +
					    "<li>" +
					    	"<b><div id='countdown_" + row + "'>" + getInterval(new Date(json.end_date).getTime()) +"</div></b>" +
					    	"<div>Time Left</div>" +
			    		"</li>" +
			  		"</ul></center>" +
				"</div>"+
			"</div>";
	
	$(".projectsContainer").append(box);
	
	//startDestTime(json.end_date, row);
}

function displayMainContainerProjects(jsonArr, value) {
	// clear the projects container
	$(".projectsContainer").html("");
	
	if(value==="admin")
		$("#ManageProjectTitle").html("Manage All The Projects");
	
	// append new projects
	for(var i=0; i<jsonArr.length; i++) {
		displayOneProject(jsonArr[i], i, value);
	}
}
