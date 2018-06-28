        function RemplirListSprint() 
    {

      var action = "ListeDeroulanteSprint";
      $.ajax({
       url : "Modele/RequetesAjax.php", 
       method:"POST", 
       async: false,
       data:{action:action}, 
       success:function(data){
        $('#ListSrint').html(data); 
      }
    });
    }