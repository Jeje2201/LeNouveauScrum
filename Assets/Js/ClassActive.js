function ClassActive(LaPage, TypeUser, NameUser){

	//Enlever actif a toutes les class
	$( "li" ).each(function() {
		$( this ).removeClass( "active" );
	});


	$( "#TitreNavBar" ).html('<p style="position: absolute; top: 15px; color: white; right: 15px;"><i class="fa fa-user" aria-hidden="true"></i> '+NameUser+' - <a style="color: white"href="Modele/ConnectionLogout.php"><span class="nav-link-text">Déconnexion</span></a> <i class="fa fa-fw fa-sign-out"></i></p>');

	//Chercher la nav qui a la page d'affiché et lui donner la class active
	$('nav a[href^="index.php?vue=' + LaPage + '"]').closest('li').addClass('active');

	//Cacher les onglets innutiles pour les non admin
	console.log(TypeUser)
	if(TypeUser !== 'ScrumMaster'){
	$( ".AdminOnly" ).each(function() {
  		$( this ).hide();
	});
	}
}

