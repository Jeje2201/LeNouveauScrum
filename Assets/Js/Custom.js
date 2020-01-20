// Quelques js esthétiques
function ClassActive(NameUser) {

  //Enlever actif a toutes les class
  $("#navbarResponsive li").each(function () {
    $(this).removeClass("active");
  });
  
  //Cherche sur quelle page il est
    var LaPage = 'Accueil'
    if(window.location.href.split('=')[1] != undefined){
      LaPage = window.location.href.split('=')[1]
    }

  //Puis cherche la nav qui a la page d'affichéE et lui donner la class active et ouvrir l'acordéon le plus proche
  $('nav a[href="index.php?vue=' + LaPage + '"]').closest("li").addClass("active").closest("ul").addClass("show");

  //Si user n'est pas admin, alors enlever tout ce qui est pour les admins
  if(isAdmin() != 1){
    $(".AdminOnly").each(function () {
      $(this).remove()
    });
  }

  //Afficher le prénom
  $("#TitreNavBar").text("Ns Scrum - " + NameUser);

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
function ShowAndClearModaleForNew(idModale,hideElement = null, showElement = null) {

  $('#'+idModale).modal('show')

  if(hideElement != null)
    $('#'+hideElement).hide()

  if(showElement != null)
    $('#'+showElement).show()

  $('#'+idModale+' input').each(function(){
    $(this).val('')
});
}

//  Affiche la modale et clear tous les input
function Notify(resultSQL, Message = 'Message non customisé') {

  if(resultSQL == true)
    $.notify(Message, "success");
  else
    $.notify("Erreur", "error");
}

function isAdmin(){

  var isAdmin = 0

  $.ajax({

    url: "Modele/GestionEmploye.php",
    method: "POST",
    async: false,
    data: {
      action: "isAdmin"
    },
    dataType: "json",
    success: function (data) {
      isAdmin = data['Admin']
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
    }
  })
    return parseInt(isAdmin)
}

function IfNoRows(idTable, Text){
  if($('#'+idTable+' td').length == 0)
  {
    $('#'+idTable).prepend('<td colspan="6"  class="centered table-dark">'+Text+'</td>')
  }
}
