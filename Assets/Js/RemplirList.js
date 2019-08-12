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

      //Si dans la page de connexion alors direct selectionner      
      if($('#ModalLogin').length == 1 && localStorage.getItem("Connexion")){
        $('#TypeEmployeOk option[value="' + localStorage.getItem("Connexion") + '"]').attr('selected', 'selected');
      }

      $( "select" ).each(function( index ) {
        $(this).select2({width: "100%"});
      });
    }
  });
}