$(function () {
	$('#grid-view input[type="checkbox"]').change(function () {
		$('#btn-remove').attr('disabled', (_, attr) => $('#grid-view input[type="checkbox"]:checked').length <= 0);
	});
});