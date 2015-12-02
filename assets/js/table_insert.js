$(document).ready(function() {
	$("#add_leerling").on("click", function() {
		var $tr = $("tbody tr:last");
		var $clone = $tr.clone();
		$clone.find(':text').val('');
		$tr.after($clone);
	});
});