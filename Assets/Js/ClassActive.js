function ClassActive(LaPage, TypeUser, NameUser) {

	//Enlever actif a toutes les class
	$("li").each(function () {
		$(this).removeClass("active");
	});
	//Puis cherche la nav qui a la page d'affiché et lui donner la class active
	$('nav a[href^="index.php?vue=' + LaPage + '"]').closest('li').addClass('active');

	$("#TitreNavBar").text('Ns Scrum - ' + NameUser);

	if (NameUser == 'Tom ') {
		$("#TitreNavBar").text('Ns Scrum (╯°□°）╯︵ ┻━┻  ( ͡° ͜ʖ ͡°) ( ͡° ʖ̯ ͡°) ( ͠° ͟ʖ ͡°) ( ͡ᵔ ͜ʖ ͡ᵔ) ( . •́ _ʖ •̀ .) ( ఠ ͟ʖ ఠ) ( ͡ಠ ʖ̯ ͡ಠ) ( ಠ ʖ̯ ಠ) ( ಠ ͜ʖ ಠ) ( ಥ ʖ̯ ಥ) ( ͡• ͜ʖ ͡• ) ( ･ิ ͜ʖ ･ิ) ( ͡ ͜ʖ ͡ ) (≖ ͜ʖ≖) (ʘ ʖ̯ ʘ) (ʘ ͟ʖ ʘ) (ʘ ͜ʖ ʘ) ┌∩┐(◣_◢)┌∩┐');
		$(".navbar-sidenav").addClass("Tom")
		$(".content-wrapper").addClass("Tom")
		$("#mainNav").addClass("Tom")
		$("#SlideNav").addClass("Tom")
	}

	//Cacher les onglets innutiles pour les non admin
	if (TypeUser !== 'ScrumMaster') {

		$(".AdminOnly").each(function () {
			$(this).hide();
		});

	}
}

