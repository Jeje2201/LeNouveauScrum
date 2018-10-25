function BarreDeRecherche(IdDivBarreDeRecherche, IdTableRecherche) {

  $("#" + IdDivBarreDeRecherche).on("keyup", function () {
    $("#" + IdTableRecherche + " tr:not(thead tr)").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf($("#" + IdDivBarreDeRecherche).val().toLowerCase()) > -1)
    });
  });
}

function GarderLaRecherche(IdDivBarreDeRecherche, IdTableRecherche){
  $("#" + IdTableRecherche + " tr:not(thead tr)").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf($("#" + IdDivBarreDeRecherche).val().toLowerCase()) > -1)
  });
}