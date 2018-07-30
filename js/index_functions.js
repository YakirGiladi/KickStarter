	
function getProjects() {
	$.post("php/getProjects.php", {fillter: "false"},
			function (data, textStatus) {
				var json = JSON.parse(data);
				$("#totalProjects").html("The total amount of project is " + json.length);
				displayMainContainerProjects(json);
				displayProjectsPoster(json);
			}
	  );
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


function displayOneProject(json, row) {

	//need to change to not null in database
	var url="project.php?id="+json.id;
	var box = "<div class='col-md-4' style='border-radius: 12px; padding:0px; width:29%; margin: 20px; border: solid 1px #d9d9de;'>" +
				"<a href='"+url+"'><img src=" + json.picture + " class='img-responsive' alt='Cinque Terre' width=100% style='max-height:200px;border-top-left-radius: 6px;border-top-right-radius: 6px;'></a>" +
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
	startDestTime(json.end_date, row);
}

function displayOneProjectPoster(json, row) {

	//need to change to not null in database
	var url="project.php?id="+json.id;
	var Indicators;
	var WrapperForSlides;
	
	if(row==0) {
		Indicators = '<li data-target="#myCarousel" data-slide-to="'+row+'" class="active"></li>';
		WrapperForSlides = 	'<div class="item active">' +
								'<a href="'+url+'">' +
									'<img src="'+json.picture+'" alt="">' +
								    '<h2 class="mostPopularDesc">'+json.name+':<br/>'+json.shortBlurb+'</h2>' +
								'</a>' +
							'</div>';
	}
	else {
		Indicators = '<li data-target="#myCarousel" data-slide-to="'+row+'"></li>';
		WrapperForSlides = 	'<div class="item">' +
								'<a href="'+url+'">' +
									'<img src="'+json.picture+'" alt="">' +
								    '<h2 class="mostPopularDesc">'+json.name+':<br/>'+json.shortBlurb+'</h2>' +
								'</a>' +
							'</div>';
	}
	
	$(".carousel-indicators").append(Indicators);
	$(".carousel-inner").append(WrapperForSlides);
}

function displayMainContainerProjects(jsonArr) {
	// clear the projects container
	$(".projectsContainer").html("");
	
	// append new projects
	for(var i=0; i<jsonArr.length; i++) {
		displayOneProject(jsonArr[i], i);
	}
}

function shuffle(o) {
    for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
    return o;
}

function displayProjectsPoster(jsonArr) {
	// clear the prev projects posters
	$(".carousel-indicators").html("");
	$(".carousel-inner").html("");
	
	jsonArr = shuffle(jsonArr);
	
	// append new projects
	var i = 0;
	while(i<jsonArr.length && i<5) {
		displayOneProjectPoster(jsonArr[i], i);
		i++;
	}
}