encodeURIComponent

/**
 * This function will fetch data from table and display under <div id="[DivId]">
 * @param {string} DivId ID de la div ou se placera le resultat de la reqete php
 * @param {string} action Argument 'action' envoyé en parametre dans le fichier php
 * @param {string} path Path du fichier php
 * @param {string} id id donné aux templates générés si on les veux dynamiques pour appeler deux fois la meme action et lui donner 2 id différents
 */
function RequeteAjax(DivId, action, path, id) {
  $.ajax({
    url: path,
    method: "POST",
    async: false,
    data: {
      action: action,
      id: id
    },
    success: function (data) {
      $('#' + DivId).html(data);
    }
  });
}

/**
 * Fonction qui permet de créer des select2 depuis le json qui est renvoyé par les requetes SQL
 * @param {string} selectID ID du Select dans lequel est retournée la liste en mode select2
 * @param {string} parametrePHP Action PHP qui va etre appelé pour savoir quelle requete sql executer
 * @param {string} pathPHP Path où se trouve le fichier php qui a la requete  
 * @param {string} parametreJS Choisir quoi faire dans le switch une fois qu'on a toutes les données
 */
function FillEmptySelect(selectID, parametrePHP, pathPHP, parametreJS) {
  $.ajax({
    url: pathPHP,
    method: "POST",
    async: true,
    dataType: "json",
    data: {
      action: parametrePHP,
    },
    success: function (data) {

      switch (parametreJS) {

        case 'LaListeDesClients':
          for (const client of data) {
            $('#' + selectID).append(`<option value="` + client.client_pk + `">` + client.client_entreprise + ` - ` + client.client_prenom + ` ` + client.client_nom + ` </option>`);
          }
          break;

        case 'LaListeDesUsers':
          for (const user of data) {
            $('#' + selectID).append(`<option value="` + user.user_pk + `">` + user.user_prenom + ` ` + user.user_nom + ` </option>`);
          }
          break;

        default:
          console.log('Oups, parametre js non reconnu pour la liste de select');

      }

      $("#" + selectID).select2({ width: "100%" });
    },
    error: function (xhr, status, erreur) {
      $.notify(erreur, "error");
    }
  });
}


