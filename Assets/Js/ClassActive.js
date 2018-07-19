function ClassActive(LaPage, TypeUser){

	//Enlever actif a toutes les class
	$( "li" ).each(function() {
		$( this ).removeClass( "active" );
	});
	
	//Chercher la nav qui a la page d'affiché et lui donner la class active
	$('nav a[href^="index.php?vue=' + LaPage + '"]').closest('li').addClass('active');

	//Cacher les onglets innutiles pour les non admin
	console.log(TypeUser)
	if(TypeUser !== 'ScrumMaster '){
	$( ".AdminOnly" ).each(function() {
  		$( this ).hide();
	});
	}
}

