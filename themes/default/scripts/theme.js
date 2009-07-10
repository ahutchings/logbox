$(document).ready(function() {
  $('tbody tr:odd').addClass('odd');
  $('#messages-by-sender').visualize({ height: 200, width: 1500 });
  $('#messages-by-month').visualize({ height: 200, width: 1500 });
});
