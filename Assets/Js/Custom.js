// Quelques js esthétiques
function ClassActive(NameUser, Admin) {

  //Enlever actif a toutes les class
  $("#navbarResponsive li").each(function () {
    $(this).removeClass("active");
  });
  
  if(window.location.href.split('=')[1] == undefined)
    var LaPage = 'Accueil'
  else
    var LaPage = window.location.href.split('=')[1]

    if(parseInt(Admin) != 1){
      $(".AdminOnly").each(function () {
        $(this).hide()
      });
    }

  //Puis cherche la nav qui a la page d'affichéE et lui donner la class active et ouvrir l'acordéon le plus proche
  $('nav a[href="index.php?vue=' + LaPage + '"]').closest("li").addClass("active").closest("ul").addClass("show");

  //Afficher le prénom
  $("#TitreNavBar").text("Ns Scrum - " + NameUser);
}

// Active ou désactive le css sidenav-toggled quand clic ou non sur la navbar "gestion"
$("#SlideNav").click(function () {
  $("body").toggleClass("sidenav-toggled");
});

//Check si a jour avec la top versio, si ce n'est pas le cas, afficher un badge rouge
$.ajax({
  url: "Modele/Changelog.php",
  method: "POST",
  data: {
    action: "GetChangelogs"
  },
  dataType: "json",
  success: function (data) {

    if(localStorage.getItem('LastVersionKnown') != data[0].changelog_numero){
      $('#ChangelogBadge').append('<span id="newsgithub" class="badge badge-danger ml-2">News !</span>')
    }

  }
})

// Fonction pour chercher dans une table depuis un input
function BarreDeRecherche(IdDivBarreDeRecherche, IdTableRecherche) {
  $("#" + IdDivBarreDeRecherche).on("keyup", function () {
    $("#" + IdTableRecherche + " tr:not(thead tr)").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf($("#" + IdDivBarreDeRecherche).val().toLowerCase()) > -1);
    });
  });
}

//  Fonction pour appliquer ce qui se trouve dans la barre de recherche sur la table, sans besoin de taper du texte dedans, c'est instentané
function GarderLaRecherche(IdDivBarreDeRecherche, IdTableRecherche) {
  $("#" + IdTableRecherche + " tr:not(thead tr)").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf($("#" + IdDivBarreDeRecherche).val().toLowerCase()) > -1);
  });
}

//  Affiche la modale et clear tous les input
function ShowAndClearModaleForNew(idModale,hideElement, showElement) {

  $('#'+idModale).modal('show')
  $('#'+hideElement).hide()
  $('#'+showElement).show()

  $('#'+idModale+' input').each(function(){
    $(this).val('')
});
}
