function ClassActive(LaPage, TypeUser, NameUser) {

	//Enlever actif a toutes les class
	$("li").each(function () {
		$(this).removeClass("active");
	});
	//Puis cherche la nav qui a la page d'affiché et lui donner la class active
	$('nav a[href^="index.php?vue=' + LaPage + '"]')
		.closest('li').addClass('active')
		.closest('ul').addClass('show');

	show

	$("#TitreNavBar").text('Ns Scrum - ' + NameUser);

	//Cacher les onglets innutiles pour les non admin
	if (TypeUser !== 'ScrumMaster') {

		$(".AdminOnly").each(function () {
			$(this).hide();
		});

	}
}