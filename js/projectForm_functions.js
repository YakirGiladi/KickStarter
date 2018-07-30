var rewardNum =0;
var editMode = false;

function fillFormData(projectId) {
	editMode = true;
	if(projectId != -1) {
		$.post("php/getProjectPageInfo.php", {id: projectId},

			function (data, textStatus) {
				$("#FormTitle").html("Edit your project!");
				$("#imgDec").html("Choose a diffrent image from your computer <br>or leave it empty for use the old one.");
				$("#videoDesc").html("Choose a diffrent video from your computer <br>or leave it empty for use the old one.");

				
				var json = JSON.parse(data);
				$("#title_input").val(json.name);
				$("#shortBlurb_input").val(json.shortBlurb);
				$("#displayImg").attr('src',json.picture);
				
				if(json.video[0] == 'h') {
					$("#URLVideoRB").attr('checked','checked');
					$("#URL_Video").val(json.video);
				}
				else {
					$("#uploudVideoRB").attr('checked','checked');
//					$("#file_Video").val(json.video);
				}
				

				var date = new Date(json.end_date);
				var yyyy = date.getFullYear();
				var mm = date.getMonth() < 9 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1); // getMonth() is zero-based
				var dd  = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();

				$('#datePicker').datepicker('update', dd+"/"+mm+"/"+yyyy);
				$("#target_input").val(json.target);		
				$("#description_input").val(json.description);

				deleteReward(1);
				for(i=0; i<json.rewards.length; i++) {
					if(json.rewards[i].maxReward != -1)
						addReward(json.rewards[i].minimumDonation, json.rewards[i].desctiption, json.rewards[i].maxReward);
				}

				$("#productForm").attr('action','php/updateProduct.php');
			}

		);
	}
	else {

	}
}

function deleteReward(value) {
	var str='#reward'+value;
	$(str).replaceWith("");
	
	for (i = value+1; i <= rewardNum; i++) { 
		var id ='#reward'+i;
		$(id).children(0).children(0)[0].innerHTML = "<b>Reward #" + (i-1) +"</b>";
		$(id).children(0)[1].children[0].children[2].attributes[1].value = "deleteReward("+(i-1)+")";
		$(id).attr('id','reward'+(i-1));
	}

	rewardNum--;
}

//function addMannagedReward(pledgeAmount, description, limitBackers) {
//	rewardNum++;
// 	var box= 	'<div id="reward'+rewardNum+'" class="col-md-12" style="margin-bottom: 20px; background-color: rgba(0, 0, 0, 0.09); padding-top: 15px; padding-bottom: 15px; border-radius: 15px;">'+
//					'<div class="col-md-3">'+
//						'<h5>'+
//							'<b>Reward #'+ rewardNum +'</b>'+
//						'</h5>'+
//					'</div>'+
//					'<div class="col-md-9">'+
//						'<div class="row">'+
//							'<div class="col-md-4"> Pledge amount</div>'+
//							'<input name="reward_minDonation[]" class="col-md-3 form-control" type="number" value="'+pledgeAmount+'"/>'+
//							'<input class="col-md-2 btn btn-success btn-xs" onclick="deleteReward('+rewardNum+')" value="Delete" type="button" style="height: 25px;" />'+
//						'</div>'+
//						'<div class="row">'+
//							'<div class="col-md-4"> Description</div>'+
//							'<textarea name="reward_desc[]" class="col-md-5 form-control">'+description+'</textarea>'+
//						'</div>'+
//						'<div class="row">'+
//							'<div class="col-md-4"> Limit backers</div>'+
//							'<center><input name="reward_limitBackers[]" class="col-md-5 form-control" value="'+limitBackers+'" min="1" type="number"></input></center>'+
//						'</div>'+																						
//					'</div>'+
//				'</div>';
//	$('#rewardContainer').append(box);
//}
function addReward() {
	addReward("", "", "1");
}

function addReward(pledgeAmount, description, limitBackers) {
	rewardNum++;
	
 	var box= 	'<div id="reward'+rewardNum+'" class="col-md-12" style="margin-bottom: 20px; background-color: rgba(0, 0, 0, 0.09); padding-top: 15px; padding-bottom: 15px; border-radius: 15px;">'+
					'<div class="col-md-3">'+
						'<h5>'+
							'<b>Reward #'+ rewardNum +'</b>'+
						'</h5>'+
					'</div>'+
					'<div class="col-md-9">'+
						'<div class="row">'+
							'<div class="col-md-4"> Pledge amount</div>'+
							'<input id="reward_minDonation_'+rewardNum+'" name="reward_minDonation[]" class="col-md-3 form-control" type="number" value="'+pledgeAmount+'" style="width: inherit;" />'+
							'<input class="col-md-2 btn btn-success btn-md" onclick="deleteReward('+rewardNum+')" value="Delete" type="button" />'+
						'</div>'+
						'<div class="row">'+
							'<div class="col-md-4"> Description</div>'+
							'<textarea id="reward_desc_'+rewardNum+'" name="reward_desc[]" class="col-md-5 form-control" style="width: 61%;">'+description+'</textarea>' +
						'</div>'+
						'<div class="row">'+
							'<div class="col-md-4"> Limit backers</div>'+
							'<center><input id="reward_limitBackers_'+rewardNum+'" name="reward_limitBackers[]" class="col-md-5 form-control" value="'+limitBackers+'" min="1" type="number" style="width: 61%;"></input></center>'+
						'</div>'+																						
					'</div>'+
				'</div>';
	$('#rewardContainer').append(box);

}

$(document).ready(function() {
	$('#file_image').change(function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		if(tmppath != null)
			$("#displayImg").attr('src', tmppath);
		else
			$("#displayImg").attr('src', "img/no_image.jpg");
	});
	
	$('#datePicker').datepicker({
	    format: 'dd/mm/yyyy'
	}).on('changeDate', function(e) {
	    // Revalidate the date field
	    //$('#eventForm').formValidation('revalidateField', 'date');
	});
});

$(document).ready(function() {
	$("#productForm").submit(function(e){
	    e.preventDefault();
	    var form = this;
	    
		if(validation())
			form.submit();
		else {
			var title = "<h3><b><center>Kickstarter Warnning</center></b></h3>";
			var body = "<p>Not all the fields are filled</p>";
			setButton_onClick('');
			showModal(title, body);
			return false;
		}
	});
});

function checkEmpty(element) {
	if($(element).val() === "") {
		$(element).parent().removeClass("has-success");
		$(element).parent().addClass("has-error");
		return false;
	}
	else {
		$(element).parent().removeClass("has-error");
		$(element).parent().addClass("has-success");
		return true;
	}
}

function validation() {
	
	var succses = true;
	
	// Validate title
	if (!checkEmpty("#title_input"))
		succses = false;
	
	// Validate shortBlurb
	if (!checkEmpty("#shortBlurb_input"))
		succses = false;
	
	// Validate image file
	if(!editMode) {
		if (!checkEmpty("#file_image"))
			succses = false;
	}
	else {
		$("#file_image").parent().removeClass("has-error");
		$("#file_image").parent().addClass("has-success");
	}
	
	// Validate video
	if (document.getElementById("URLVideoRB").checked == true) {
		if (!checkEmpty("#URL_Video"))
			succses = false;
	}
	else {
		if(!editMode) {
			if (!checkEmpty("#file_Video"))
				succses = false;
		}
		else {
			$("#file_Video").parent().removeClass("has-error");
			$("#file_Video").parent().addClass("has-success");
		}
	}
	
	// Validate date
	if (!checkEmpty("#date_input"))
		succses = false;
	
	// Validate target
	if (!checkEmpty("#target_input"))
		succses = false;
	
	// Rewards
	for(i=1; i<=rewardNum ;i++) {
		if (!checkEmpty("#reward_minDonation_"+i))
			succses = false;
		if (!checkEmpty("#reward_desc_"+i))
			succses = false;
		if (!checkEmpty("#reward_limitBackers_"+i))
			succses = false;
	}
	
	// Validate target
	if(CKEDITOR.instances.description_input.getData() === "") {
		$("#description_input").removeClass("has-success");
		$("#description_input").addClass("has-error");
		succses = false;
	}
	else {
		$("#description_input").removeClass("has-error");
		$("#description_input").addClass("has-success");
	}
	
	return succses;
}