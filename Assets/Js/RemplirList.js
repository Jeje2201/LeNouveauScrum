        function RemplirListEtatObjectif(DivId) 
        {

          var action = "ListeDeroulanteEtatObjectif";
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

        function RemplirListTypeEmploye(DivId) 
        {

          var action = "ListeDeroulanteTypeEmploye";
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

        function RemplirListTypeTypeProjet(DivId) 
        {

          var action = "ListeDeroulanteTypeProjet";
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

        function RemplirListTypeEmployeEtType(DivId) 
        {

          var action = "ListeDeroulanteEmployeActifTrieParType";
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

              function RemplirListImages(Div) {
        var action = "LoadPictures";
        $.ajax({
          url: "Modele/ActionGestionProjet.php",
          method: "POST",
          data: { action: action },
          success: function (data) {
            $('#' + Div).html(data);
          }
        });
      }

              function RemplirListeEmployeCheckBox(DivId) 
        {

          var action = "ListEmployeCheckBox";
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

                function RemplirTypeTache(DivId) 
        {

          var action = "RemplirTypeTache";
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