// delete record of db by model button
$(document).ready(function() {
	$('.delete-record').on('click', function() {
		var href = $(this).attr('href');
		$('#delete-modal .btn-danger').attr('href', href);
		$('#delete-modal').modal('show');
		return false;
	});
});
// //delete record of db by model button


















