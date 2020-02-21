//Enlever actif a toutes les class
$("#navbarResponsive li").each(function () {
  $(this).removeClass("active");
});

//Check si en dev mod par le :.../index
if(location.href.match(/:[0-9]{2,4}/g) != null){
  document.title = "Dev Mode";
  document.getElementById('iconAppli').href = "/Assets/Image/Autre/icon_dev.png";
}

//Fait apparaitre un scroll top si user trop scroll down
$(window).scroll(function () {
  if ($(this).scrollTop() >= 50) {        
    $('#return-to-top').fadeIn(200);    
  } else {
    $('#return-to-top').fadeOut(200);   
  }
});
$('#return-to-top').click(function () {      
  $('body,html').animate({
    scrollTop: 0                      
  }, 500);
});

//Cherche sur quelle page il est puis cherche la nav qui a la page d'affichéE et lui donner la class active et ouvrir l'acordéon le plus proche
  var LaPage = 'Accueil'
  if(window.location.href.split('=')[1] != undefined){
    LaPage = window.location.href.split('=')[1]
  }
$('nav a[href="index.php?vue=' + LaPage + '"]').closest("li").addClass("active").closest("ul").addClass("show");

//Si user n'est pas admin, alors enlever tout ce qui est pour les admins
if(isAdmin() != 1){
  $(".AdminOnly").each(function () {
    $(this).remove()
  });
}
//Check si a une notification importante est a afficher, si oui, l'afficher
$.ajax({
  url: "Modele/Autre.php",
  method: "POST",
  dataType: 'json',
  data: {
    action: "UrgentNotification"
  },
  success: function (data) {
    if(data.Message != ""){
    $('.container-fluid').prepend('<div class="alert alert-'+data.Type+'" role="alert">'+data.Message+'</div>')
  }
  }
})

/**
 * Fonction pour chercher dans une table depuis un input
 * @param {string} IdDivBarreDeRecherche Id de la bar de recherche dans laquelle on tape pour chercher
 * @param {string} IdTableRecherche Table de recherche sur laquelle on va chercher ce qu'on a tapé
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
 * @param {string} IdDivBarreDeRecherche Id de la bar de recherche dans laquelle on tape pour chercher
 * @param {string} IdTableRecherche Table de recherche sur laquelle on va chercher ce qu'on a tapé
 */
function GarderLaRecherche(IdDivBarreDeRecherche, IdTableRecherche) {
  $("#" + IdTableRecherche + " tr:not(thead tr)").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf($("#" + IdDivBarreDeRecherche).val().toLowerCase()) > -1);
  });
}

/**
 * Affiche la modale, clear tous ses input et si donnée, cache et affiche un input pour choisir si afficher "créer" ou "maj"
 * @param {string} idModale modale qu'on va show et clear tout ses inputs
 * @param {string} hideElement input qu'on veut cacher
 * @param {string} showElement input qu'on veut afficher
 */
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

/**
 * Créer une notif qui affiche qu'il y a une erreur si le résultat n'est pas "1" et sinon un custom message
 * @param {string} resultSQL Prend le retour de la requete sql qui devrait etre "1" si tout c'est bien passé
 * @param {string} Message Message qu'on affiche si tout c'est bien pass"
 */
function Notify(resultSQL, SucessMessage = 'Message succès', ErrorMessage = 'Message erreur') {

  if(resultSQL == true)
    $.notify(SucessMessage, "success");
  else
    $.notify(ErrorMessage, "error");
}

/**
 * Retourne 1 / true si le user est admin sinon 0 / false
 */
function isAdmin(){

  var isAdmin = 0

  $.ajax({

    url: "Modele/User.php",
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

/**
 * 
 * @param {string} idTable ID Table qu'on va check
 * @param {string} Text Texte a afficher si aucune résultat n'arrive
 */
function IfNoRows(idTable, Text = "Aucune donnée.."){
  if($('#'+idTable+' td').length == 0){
    $('#'+idTable).prepend('<td colspan="6"  class="text-center bg-light">'+Text+'</td>')
  }
}
