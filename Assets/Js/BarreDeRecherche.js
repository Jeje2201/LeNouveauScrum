   
function BarreDeRecherche(IdDivBarreDeRecherche, IdTableRecherche){

    $("#"+IdDivBarreDeRecherche+"").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#"+IdTableRecherche+" tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

}