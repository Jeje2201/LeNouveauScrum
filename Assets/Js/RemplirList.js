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

function FillEmptySelect(returnDiv, parametrePHP, pathPHP, parametreJS) {
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
            $('#' + returnDiv).append(`<option value="` + client.client_pk + `">` + client.client_entreprise + ` - ` + client.client_prenom + ` ` + client.client_nom + ` </option>`);
          }
          break;

        default:
          console.log('Oups, parametre js non reconnu pour la liste de select');

      }

      $("#" + returnDiv).select2({ width: "100%" });
    }
  });
}


