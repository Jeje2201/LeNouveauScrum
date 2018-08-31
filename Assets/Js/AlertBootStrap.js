/**
 * Permet de faire apparaitre une popup plus sympa
 * @param {string} message Le message a faire apparaitre dans la popup 
 */
function BootstrapAlert(message) {
	$('#snackbar').addClass('show');

	$('#snackbar').html(message);

	setTimeout(function () {
		$('#snackbar').removeClass('show');
	}, 2500);

}