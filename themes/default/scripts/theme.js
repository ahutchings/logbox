$(document).ready(function () {
    $('tbody tr:odd').addClass('odd');
  
    // statistics page
    $('#messages-by-sender').visualize({ height: 200, width: 1500 });
    $('#messages-by-month').visualize({ height: 200, width: 1500 });
  
    // home page
    $('#sender').change(function () {
    	$('#messages-form').submit();
	});
    $('#dates').change(function () {
    	$('#messages-form').submit();
	});
});
