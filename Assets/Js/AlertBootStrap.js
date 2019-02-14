/**
 * Permet de faire apparaitre une popup plus sympa
 * @param {string} message Le message a faire apparaitre dans la popup 
 */
function BootstrapAlertDefaut(message) {
	$('#snackbar').addClass('show');

	$('#snackbar').html(message);

	setTimeout(function () {
		$('#snackbar').removeClass('show');
	}, 2500);

}

function BootstrapAlertError(message) {
	$('#snackbar').addClass('show');
	$('#snackbar').css('background-color','red');

	$('#snackbar').html(message);

	setTimeout(function () {
		$('#snackbar').removeClass('show');
		$('#snackbar').css('background-color','#333');
	}, 2500);

}