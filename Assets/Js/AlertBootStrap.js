function BootstrapAlert(message){
// Get the snackbar DIV

   	$('#snackbar').addClass('show');

   	$('#snackbar').html(message);

	    setTimeout(function(){
	    	$('#snackbar').removeClass('show');
	    }, 2500);
	
}
