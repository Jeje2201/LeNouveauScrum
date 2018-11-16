/**
 * Quelques js esthétiques			
 * @param {string} LaPage Affecter la classe active dans la navbar a la page active, en cours 
 * @param {*} TypeUser Cacher les onglets qui sont de toutes façon innaccessibles en fonction des droits 
 * @param {string} NameUser Permet d'afficher le nom du user connecté en haut de l'appli
 */
function ClassActive(LaPage, TypeUser, NameUser) {

	//Enlever actif a toutes les class
	$("li").each(function () {
		$(this).removeClass("active");
	});
	//Puis cherche la nav qui a la page d'affiché et lui donner la class active
	$('nav a[href^="index.php?vue=' + LaPage + '"]')
		.closest('li').addClass('active')
		.closest('ul').addClass('show');

	$("#TitreNavBar").text('Ns Scrum - ' + NameUser);

	//Cacher les onglets innutiles pour les non admin
	if (TypeUser !== 'ScrumMaster') {

		$(".AdminOnly").each(function () {
			$(this).hide();
		});

	}
}