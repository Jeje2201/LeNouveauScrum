function BootstrapAlert(message){
// Get the snackbar DIV

   	temps = parseInt(localStorage.getItem('TempsAffichagePopup'));

   	$('#snackbar').addClass('show');

   	$('#snackbar').html(message);

	if (isNaN(temps))
	    setTimeout(function(){
	    	$('#snackbar').removeClass('show');
	    }, 1200);
	
	else
		setTimeout(function(){
			$('#snackbar').removeClass('show');
		}, parseInt(localStorage.getItem('TempsAffichagePopup')));
}
