/**
 * Fonction pour chercher dans une table depuis un input
 * @param {string} IdDivBarreDeRecherche Id de l'input de la barre de recherche sur lequel on va check quand on tape du text
 * @param {string} IdTableRecherche id table sur laquel appliquer la recherche
 */
function BarreDeRecherche(IdDivBarreDeRecherche, IdTableRecherche) {

  $("#" + IdDivBarreDeRecherche).on("keyup", function () {
    $("#" + IdTableRecherche + " tr:not(thead tr)").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf($("#" + IdDivBarreDeRecherche).val().toLowerCase()) > -1)
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
    $(this).toggle($(this).text().toLowerCase().indexOf($("#" + IdDivBarreDeRecherche).val().toLowerCase()) > -1)
  });
}