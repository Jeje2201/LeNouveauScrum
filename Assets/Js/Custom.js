/**
 * Quelques js esthétiques
 * @param {string} LaPage Affecter la classe active dans la navbar a la page active, en cours
 * @param {*} TypeUser Cacher les onglets qui sont de toutes façon innaccessibles en fonction des droits
 * @param {string} NameUser Permet d'afficher le nom du user connecté en haut de l'appli
 */
function ClassActive(LaPage, TypeUser, NameUser) {
  //Enlever actif a toutes les class
  $("exampleAccordion li").each(function () {
    $(this).removeClass("active");
  });

  //Puis cherche la nav qui a la page d'affichéE et lui donner la class active
  $('nav a[href^="index.php?vue=' + LaPage + '"]').closest("li").addClass("active").closest("ul").addClass("show");

  //Afficher le prénom
  $("#TitreNavBar").text("Ns Scrum - " + NameUser);
}

/**
 * Active ou désactive le css sidenav-toggled quand clic ou non sur la navbar "gestion"
 */
$("#SlideNav").click(function () {
  $("body").toggleClass("sidenav-toggled");
});

/**
 * Fonction pour chercher dans une table depuis un input
 * @param {string} IdDivBarreDeRecherche Id de l'input de la barre de recherche sur lequel on va check quand on tape du text
 * @param {string} IdTableRecherche id table sur laquel appliquer la recherche
 */
function BarreDeRecherche(IdDivBarreDeRecherche, IdTableRecherche) {
  $("#" + IdDivBarreDeRecherche).on("keyup", function () {
    $("#" + IdTableRecherche + " tr:not(thead tr)").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf($("#" + IdDivBarreDeRecherche).val().toLowerCase()) > -1);
    });
  });
}

/**
 * Fonction pour appliquer ce qui se trouve dans la barre de recherche sur la table, sans besoin de taper du texte dedans, c'est instentané
 * @param {string} IdDivBarreDeRecherche Id de l'input de la barre de recherche sur lequel on va check quand on tape du text
 * @param {string} IdTableRecherche id table sur laquel appliquer la recherche
 */
function GarderLaRecherche(IdDivBarreDeRecherche, IdTableRecherche) {
  $("#" + IdTableRecherche + " tr:not(thead tr)").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf($("#" + IdDivBarreDeRecherche).val().toLowerCase()) > -1);
  });
}
