$(document).ready(function() {
	appendModal();
});


function appendModal() {
	var modal =		'<div class="modal-dialog">' +
						'<div class="modal-content">' +
							'<div class="modal-header">' +
								'<button type="button" class="close" data-dismiss="modal">&times;</button>' +
								'<div class="modal-title"></div>' +
							'</div>' +
							'<div class="modal-body"></div>' +
							'<div class="modal-footer">' +
								'<center><button type="button" class="modalBT btn btn-info" data-dismiss="modal" onClick="">Close</button></center>' +
							'</div>' +
						'</div>' +
					'</div>';

	$("#myModal").append(modal);
}

function setTitle(title) {
	$('.modal-title').html('');
	$('.modal-title').append(title);
}

function setBody(body) {
	$('.modal-body').html('');
	$('.modal-body').append(body);
}

function setButton_onClick(action) {
	$('.modalBT').attr('onClick', action);
}

function showModal(title, body) {
	//setButton_onClick('');
	setTitle(title);
	setBody(body);
	$('#myModal').modal({ show: true});
}