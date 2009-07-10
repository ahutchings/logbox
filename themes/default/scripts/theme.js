$(document).ready(function () {
    $('tbody tr:odd').addClass('odd');

    // home page
    $('#sender').change(function () {
    	$('#messages-form').submit();
	});
    $('#dates').change(function () {
    	$('#messages-form').submit();
	});
});
