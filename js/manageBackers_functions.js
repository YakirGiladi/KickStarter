
function showBackersTable() {
	$.post("php/getBackers.php",
			function (data, textStatus) {
				var jsonArr= JSON.parse(data);
				
				$(".table_data").html("");
					
				//for (var i = 0 ; i <  jsonArr.length ; i++) {
				var box = "<div class='container'>"+
							  "<div class='table-responsive' >"+
								 "<table class='table table-hover' style='width: 60%'>"+
								  	"<thead>"+
									  	"<tr>"+
									  		"<th>Name</th>"+
									        "<th>Email</th>"+
									        "<th>Project Name</th>"+
									        "<th>Pledge ($)</th>"+
									        "<th>Reward Desctiption</th>"+
									        "<th></th>"+
									    "</tr>"+
								    "</thead>"+
								    "<tbody id='table_body'>"+
							
								    "</tbody>"+
			 					"</table>"+
			 				  "</div>"+
						   "</div>";
				
				$(".backersContainer").append(box);
				
				for (var i = 0 ; i <  jsonArr.length ; i++) {
					var tbody = "<tr id='actionId_"+jsonArr[i].actionid+"'>"+
									"<td>"+jsonArr[i].name        +" </td>"+
									"<td>"+jsonArr[i].email 	  +" </td>"+
									"<td>"+jsonArr[i].projectName +" </td>"+
									"<td>"+jsonArr[i].donate 	  +" </td>"+
									"<td>"+jsonArr[i].desctiption +" </td>"+
									"<td><button type='button' class='btn btn-danger' onclick='deleteAction("+jsonArr[i].actionid+")'>Delete</button></td>"+
								"</tr>";
					$("#table_body").append(tbody);		
				}
				
			});
}

function deleteAction(id) {
	$.post("php/deleteAction.php", {actionId: id},
			function (data, textStatus) {
				if (data != -1) {
					$("#actionId_"+id).replaceWith("");
					
					// Alart
					var title = "<h3><b><center>Kickstarter</center></b></h3>";
					var body = "<p>"+data+"</p>";
					showModal(title, body);
				}
			}
	);
	
}
