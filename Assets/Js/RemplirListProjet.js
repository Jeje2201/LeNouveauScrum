        function RemplirListProjet(DivId) 
    {

      var action = "ListeDeroulanteProjet";
      $.ajax({
       url : "Modele/RequetesAjax.php", 
       method:"POST",
       async: false,
       data:{action:action}, 
       success:function(data){
        $('#'+DivId+'').html(data); 
      }
    });
    }