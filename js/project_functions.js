
//global var
var projectid;
var reward;
var donateSum = 5000;

function getProjectPageInfo(projectId, userType) {
	projectid=projectId; 
	$.post("php/getProjectPageInfo.php", { id: projectId},
			function (data, textStatus) {
				addInformationProjectToPage(JSON.parse(data), userType);
			}
	  );
}

function donate(destDate) {
	if(userType != -1) {
		$.post("php/getProjectPageInfo.php", { id: projectid},
				function (data, textStatus) {
					var title = '<center>' +
									'<h3 style="font-weight: bold;">Kickstarer Donation</h3>' +
									'<h4>' +
										'<p style="font-size: 17px;">' +
											'You can choose any kind of pledged and get a present </br>' +
											'when the target have reached or just donate the amount that </br>' +
											'you want !!!' +
						        		'</p>' +
						        	'</h4>' +
					        	'</center>';
					var body = appendRewardForDonate(JSON.parse(data));
					showModal(title, body);
				}
		);
	}
	else {
		var title = "<h3><b><center>Kickstarter Warning</center></b></h3>";
		var body = "<p>You have to log in</p>";
		showModal(title, body);
	}
}


function startDestTime(destDate) {
	// set the date we're counting down to
	var target_date = new Date(destDate).getTime();
	 
	// variables for time units
	var days, hours, minutes, seconds;
	 
	// get tag element
	var countdown = document.getElementById("countdown");
	 
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
    			return "<b>" + seconds +  " Seconds</b>";
    		}
    		else {
    			return "<b>" + minutes +  " Minutes</b>";
    		}
    	}
    	else {
    		return "<b>" + hours +  " Hours</b>";
    	}
    }
    else {
    	return "<b>" + days + " Days</b>";  
    }
}

//Set the value of the textBox
function donateValue(value) {
	$('#donate_value').val(value+"$");
	donateSum = value;
}

//Set the value of the slider
function changeBar(value) {
		
	var lastChar = value[value.length-1];
	
	if(lastChar==='$') {
		$('#donate_value').val(value);
		$('#donatebar').val(value.substring(0,value.length-1));
		donateSum = value.substring(0,value.length-1);
	}
	else {
		$('#donate_value').val(value+"$");
		$('#donatebar').val(value);
		donateSum = value;
	}
}

//Set DB:actions to donate money
function donateMoney() {
	
	var indexMoneyId;
	for (var i = 0; i < reward.length ; i++) {
		if(reward[i].desctiption.localeCompare("money") ==0)
			indexMoneyId=i;
	}
		
	if (confirm("Are you Sure you want to pledge " + donateSum +"$") == true){ 
		var myJsonObject = {
			"rewardId" : reward[indexMoneyId].rewardId,
			"projectid" : projectid,
			"donation" : donateSum,
			"user_id" : user_id
		}
		$.post("php/insertDonate.php", {data: myJsonObject},
			function (data, textStatus) {
				var title = "<h3><b><center>Kickstarter</center></b></h3>";
				var body = "<p>Thanks for your pledge!</p>";
				showModal(title, body);
			}
		);
	}
}


// Adds the project page info
function addInformationProjectToPage(json, userType) {
	addInformationHeader(json, userType);
	addInformationBody(json, userType);
}

// Adds the header info
function addInformationHeader(json, userType) {
	var videoBox;
	if(json.video[0]=='v') {
		videoBox = 	'<video controls="controls" width="640" height="360">'+
						'<source src="'+json.video+'" type="video/mp4" />'+
						'<object type="application/x-shockwave-flash" data="http:// flowplayer-3.2.1.swf" width="640" height="360">'+
							'<paramname ="allowFullScreen" value="true" />'+
						'</object>'+
					'</video>';
	}
	else
		videoBox =	"<div class='embed-responsive embed-responsive-16by9'>"+	
						"<iframe class='embed-responsive-item' src='"+json.video+"'></iframe>"+
					"</div>";
		
		
	var box =	"<div class='col-md-12 text-center' style='margin: 15px;'>"+
					"<h1>"+json.name+"</h1>"+"<p> By <b>"+json.owner+"</b></p>" +
				"</div>"+
				"<div class='col-md-12'>"+
					"<div class='col-md-8'>"+
						videoBox +
					"</div>"+
					"<div class='col-md-4'>"+
						"<div class='row'>"+
							"<div class='col-md-12'>"+
								"<h1 id='backers_count' style='font-size: 50px; margin-bottom: -10px;'>"+
									"<b>"+json.backers+"</b>"+
								"</h1>"+
								"<h5>backers</h5>"+
							"</div>"+
							"<div class='col-md-12'>"+
								"<h1 id='goal' style='font-size: 50px; margin-bottom: -10px;'>"+
									"<b>$"+json.gathered+"</b>"+
								"</h1>"+
								"<h5>Pledged of $"+json.target+" goal</h5>"+
							"</div>"+
							"<div class='col-md-12'>"+
								"<h1 id='countdown' style='font-size: 50px; margin-bottom: -10px;'>" +
									getInterval(new Date(json.end_date).getTime()) +
								"</h1>"+
								"<h5>Time Left</h5>"+
							"</div>"+
							"<div class='col-md-12' style='margin-top: 20px;'>"+
								"<a onclick='donate()' class='btn btn-lg btn-success donate_btn'>Pledge</a>"+
							"</div>"+
						"</div>"+
					"</div>"+
				"</div>";

		
	$(".viewDetails").html(box); //Update the info view (first section)
	startDestTime(json.end_date);

	//Set disable and enable for donate button and tip tool
	if (userType != -1) {
		$(".donate_btn").attr('enabled', 'enabled');
		$(".donate_btn").attr("title", "Click"); //tipTool
	} else {
		$(".donate_btn").attr('disabled', 'disabled');
		$(".donate_btn").attr("title", "You Have to Log In");//tipTool
	}
}

function addInformationBody(json, userType) {
	addInformationDescription(json);
	addInformationRewards(json.rewards, userType);
}
//Set DB:actions to donate reward
function donateForReward(rewardId, gone) {
	if (!gone) {
		if (confirm("Are you Sure you want to pledge ") == true){ 
			for (var i = 0; reward.length > i ; i++) {
				if(reward[i].rewardId==rewardId){
					var myJsonObject = {
					"rewardId" : rewardId,
					"projectid" : projectid,
					"donation" : reward[i].minimumDonation,
					"user_id" : user_id
					}
	
					$.post("php/insertDonate.php", {data: myJsonObject},
						function (data, textStatus) {
							var title = "<h3><b><center>Kickstarter</center></b></h3>";
							var body = "<p>Thanks  you , Just wait to your reward!!!</p>";
							showModal(title, body);
						}
					);
	
				}
			}
		}
	}
	else {
		var title = "<h3><b><center>Kickstarter</center></b></h3>";
		var body = "<p>All rewards was gone, please choose other reward!!!</p>";
		showModal(title, body);
	}
}

// Adds the description info
function addInformationDescription(json) {
	$("#about").html(json.description); //update the about box
}

// Adds the rewards info
function addInformationRewards(jsonArr, userType) {
	// clear the projects container
	$(".rewards").html('<div class="jumbotron rewardRight" style="padding-left: 0; padding-top: 17px; padding-right: 5px; padding-bottom: 0px;"></div>');
	
	// append new projects
	for(var i=0; i<jsonArr.length; i++) {
		appendOneReward(jsonArr[i], userType);
	}
}

//Adds one reward info
function appendOneReward(json, userType) {

	var goneBox = "";
	if (json.rewardBackers==json.maxReward)
		goneBox = '<span class="label label-default" style="font-size: 90%; margin-left: 5px;">All gone!</span>';

	var box =	'<div class="container" style="padding-bottom: 20px;">' +
					'<div class="col-md-12 panel panel-primary">' +
						'<p class="panel-heading"style="font-size: 15px;"><b>Pledge ' + json.minimumDonation + '$ or more</b></p>' +
						'<p style="font-size: 12px;">' +
							'<span class="glyphicon glyphicon-user"></span>' +
							'<b>' + json.rewardBackers + ' backers</b>' +
							goneBox +
						'</p>' +
						'<p class="donate_description" style="font-size: 15px;">' +
							json.desctiption +
						'</p>' +
					'</div>' +
				'</div>';
	
	$(".rewardRight").append(box);
}

//Adds the reward info to ui 'donate' button event
function appendRewardForDonate(json) {
	reward = json.rewards; //global var
	
	var body = "";	
	for(var i=1; i<reward.length; i++) {
		var goneBox = "";
		var gone = false;
		if (reward[i].rewardBackers==reward[i].maxReward) {
			goneBox = '<span class="label label-default" style="font-size: 90%; margin-left: 5px;">All gone!</span>';
			gone = true;
		}

		if(reward[i].desctiption.localeCompare("money")!=0)  {
			body +=	'<div class="jumbotron" style="padding-left: 0; padding-top: 10px; padding-right: 5px; margin-bottom: 10px;">' +
						'<div class="container" onclick="donateForReward('+reward[i].rewardId+','+gone+')"><span class="label label-default">'+(i)+'</span>'+
							'<div class="col-md-12 panel panel-primary rewardDonate" style="margin-bottom: -20px">' +
								'<p class="panel-heading"style="font-size: 15px;"><b>Pledge ' + reward[i].minimumDonation + '$ or more</b></p>' +
								'<p style="font-size: 12px;">' +
									'<span class="glyphicon glyphicon-user"></span>' +
									'<b>' + reward[i].rewardBackers + ' backers</b>' +
									goneBox +
								'</p>' +
								'<p class="donate_description" style="font-size: 15px;">' +
									reward[i].desctiption +
								'</p>' +
							'</div>' +
						'</div>' +
					'</div>';
		}
	}
	
	body += '<div class="container" style="width: 100%;">'
	body += 	'<center><h3>or just press  <button onclick="donateMoney()" style="font-size: 15px;" class="btn btn-lg btn-warning"> HERE </button>  to pledge an amount </h3></center>'
	body +=		'<div class="col-md-12">';
	body += 		'<div class="col-md-8"><input type="range" id="donatebar" style="margin-top:37px" name="points" min="0" max="10000" onchange="donateValue(this.value)"></div>';
	body += 		'<div class="col-md-4"><input id="donate_value" class="form-control" type="text" value="5000$" onchange="changeBar(this.value)" style="margin-top: 30px;text-align: center;background-color: #EEE9FB;font-weight: bold;font-size: larger;" /></div>';
	body +=		'</div">';
	body +=	'</div">';
	
	$("#donate_value").attr('disabled', 'disabled');
	
	return body;
}
			


