encodeURIComponent

/**
 * This function will fetch data from table and display under <div id="[DivId]">
 * @param {string} DivId Div ou se placera le resultat de la reqete php
 * @param {string} action Argument 'action' envoyé en parametre dans le fichier php
 * @param {string} path Path du fichier php
 */
function RequeteAjax(DivId, action, path) {
  $.ajax({
    url: path,
    method: "POST",
    async: false,
    data: {
      action: action
    },
    success: function (data) {
      $('#' + DivId).html(data);
    }
  });
}