function BarreDeRecherche(IdDivBarreDeRecherche, IdTableRecherche) {

  $("#" + IdDivBarreDeRecherche).on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#" + IdTableRecherche + " tr:not(thead tr)").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
}