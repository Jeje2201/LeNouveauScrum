//Si ne reconnait pas l'utilisateur, le rediriger vers la connexion
if (!localStorage.getItem("Connexion")) {
  $('.container-fluid').html("<h1>Erreur de cache</h1>Je ne reconnais pas qui tu es. Peut-tu te connecter à nouveau en cliquand <a href='Modele/ConnectionLogout.php'>ICI</a> ?")
}

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
  $('nav a[href^="index.php?vue=' + LaPage + '"]').closest("li").addClass("active").closest("ul").addClass("show");

  $("#TitreNavBar").text("Ns Scrum - " + NameUser);

  //Cacher les onglets innutiles pour les non admin
  if (TypeUser !== "ScrumMaster") {
    $(".AdminOnly").each(function () {
      $(this).hide();
    });
  }
}

/**
 * Permet de faire apparaitre une popup plus sympa
 * @param {string} message Le message a faire apparaitre dans la popup
 */
function BootstrapAlertDefaut(message) {
  $("#snackbar").addClass("show");

  $("#snackbar").html(message);

  setTimeout(function () {
    $("#snackbar").removeClass("show");
  }, 2500);
}

/**
 * Permet de faire apparaitre une popup plus sympa
 * @param {string} message Le message a faire apparaitre dans la popup
 */
function BootstrapAlertError(message) {
  $("#snackbar").addClass("show");
  $("#snackbar").css("background-color", "red");

  $("#snackbar").html(message);

  setTimeout(function () {
    $("#snackbar").removeClass("show");
    $("#snackbar").css("background-color", "#333");
  }, 2500);
}

/**
 * Active ou désactive le css sidenav-toggled quand clic ou non sur la navbar "gestion"
 */
$("#SlideNav").click(function () {
  $("body").toggleClass("sidenav-toggled");
});

/**
 *  Mettre la taille du select2 au max
 * @param {string} div Le div sur lequel jouer
 */
function SetSelect2(div) {
  $(div).select2({width: "100%"});
}

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
