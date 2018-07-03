        function RemplirListSprint(DivId) 
        {

          var action = "ListeDeroulanteSprint";
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

        function RemplirListEmploye(DivId) 
        {

          var action = "ListeDeroulanteEmploye";
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

        function RemplirListEmployeActif(DivId) 
        {

          var action = "ListeDeroulanteEmployeActif";
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

        function RemplirListTypeInterferance(DivId) 
        {

          var action = "ListeDeroulanteTypeInterferance";
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