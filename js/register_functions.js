function validation() {
	var flag = true;
	
	// Validate Name
	if($("#Name").val() === "") {
		$("#Name").parent().removeClass("has-success");
		$("#Name").parent().addClass("has-error");
	}
	else {
		$("#Name").parent().removeClass("has-error");
		$("#Name").parent().addClass("has-success");
	}
	
	var emailPattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	// Validate Emails
	if($(".email1").val() === $(".email2").val()) {
		if ($(".email1").val().match(emailPattern) && $(".email1").val() !== "")  {
			$(".email1").parent().removeClass("has-error");
			$(".email1").parent().addClass("has-success");
		}
		else {
			$(".email1").parent().addClass("has-error");
			$(".email1").parent().removeClass("has-success");
			flag = false;
		}
		
		if ($(".email2").val().match(emailPattern) && $(".email2").val() !== "")  {
			$(".email2").parent().removeClass("has-error");
			$(".email2").parent().addClass("has-success");
		}
		else {
			$(".email2").parent().addClass("has-error");
			$(".email2").parent().removeClass("has-success");
			flag = false;
		}
	}
	else {
		$(".email1").parent().addClass("has-error");
		$(".email1").parent().removeClass("has-success");
		
		$(".email2").parent().addClass("has-error");
		$(".email2").parent().removeClass("has-success");
		flag = false;
	}
		
	// Validate Passwords
	if($(".pass1").val() === $(".pass2").val()) {
		if ($(".pass1").val() !== "")  {
			$(".pass1").parent().removeClass("has-error");
			$(".pass1").parent().addClass("has-success");
		}
		else {
			$(".pass1").parent().addClass("has-error");
			$(".pass1").parent().removeClass("has-success");
			flag = false;
		}
		
		if ($(".pass2").val() !== "")  {
			$(".pass2").parent().removeClass("has-error");
			$(".pass2").parent().addClass("has-success");
		}
		else {
			$(".pass2").parent().addClass("has-error");
			$(".pass2").parent().removeClass("has-success");
			flag = false;
		}
	}
	else {
		$(".pass1").parent().addClass("has-error");
		$(".pass1").parent().removeClass("has-success");
		
		$(".pass2").parent().addClass("has-error");
		$(".pass2").parent().removeClass("has-success");
		flag = false;
	}
	
	if(flag) {
		var myJsonObject = {
			"name" : $("#Name").val(),
			"email" : $("#EmailAddress").val(),
			"password" : $("#Password").val(),
			"type" : $("#CustomerType").val()
		}
		
		$.post("php/register.php", {data: myJsonObject},
			function (data, textStatus) {
				if(data == 1) {
					var title = "<h3><b><center>Kickstarter</center></b></h3>";
					var body = "<p>Thank you for registering!</p>";
					setButton_onClick('window.location.replace("index.php")');
					showModal(title, body);
				}
				else {
					var title = "<h3><b><center>Kickstarter Warnning</center></b></h3>";
					var body = "<p>"+data+"</p>";
					setButton_onClick('');
					showModal(title, body);
				}
			}
		);
	}
}