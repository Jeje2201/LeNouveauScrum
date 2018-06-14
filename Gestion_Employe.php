  <html>
  <?php include('header.php'); ?>
  <body class="fixed-nav sticky-footer" id="page-top">
    <div class="content-wrapper">
      <div class="container">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body" id="InterieurDeLalert">
              </div>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <div class="form-row">
            <div class="col-md-3">
              <button type="button" id="modal_button" class="btn btn-info">Créer un(e) employé(e)</button>

            </div>
          </div>
          <br />

          <input class="form-control" id="BarreDeRecherche" type="text" placeholder="Rechercher..">

          <div id="result" class="table-responsive"> 

          </div>
        </div>
      </div>
    </body>
    </html>

    <div id="customerModal" class="modal fade">
     <div class="modal-dialog">
      <div class="modal-content">
       <div class="modal-header">
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">

        <div class="form-group">
        <label>Prénom</label>
        <input class="form-control" name="Prenom" id="Prenom" type="text" placeholder="Jackouille">
        </div>

        <div class="form-group">
        <label>Nom</label>
        <input class="form-control" name="Nom" id="Nom" type="text"placeholder="LaFripouille">
        </div>

        <div>
        <label>Actif</label>
        <input id="Actif" type="checkbox" checked>
        </div>

        <div class="form-group">
        <label>Couleur</label>
        <input name="Couleur" id="Couleur" type="color" value="#ff00fa">
        </div>

      </div>
      <div class="modal-footer">
        <input type="hidden" name="id" id="id" />
        <input type="submit" name="action" id="action" class="btn btn-success" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<?php require_once __Dir__ . '/footer.php'; ?>

<script>

  $(document).ready(function(){

    $("#BarreDeRecherche").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    fetchUser(); 

    function fetchUser() 
    {
      var action = "Load";
      $.ajax({
       url : "Modele/ActionGestionEmploye.php", 
       method:"POST", 
       data:{action:action}, 
       success:function(data){
        $('#result').html(data); 
      }
    });     
    }

    $('#modal_button').click(function(){
      $('#customerModal').modal('show'); 
      $('.modal-title').text("Ajouter un employé"); 
      $('#action').val('Ajouter'); 
      $('#Prenom').val('');
      $('#Nom').val('');
      $('#Actif').prop( "checked", true ); 
      $('#Couleur').val('#ff00fa');
    });

    $('#action').click(function(){
      var Nom_Employe = $('#Nom').val();
      var Prenom_Employe = $('#Prenom').val();
      if (document.getElementById("Actif").checked == true){
        var Actif = 1;
      } else {
        var Actif = 0;
      }
      var Couleur = $('#Couleur').val();
      console.log(typeof(Couleur))
      var Initial = Prenom_Employe.charAt(0)+Nom_Employe.charAt(0);
      var action = $('#action').val();
      var id = $('#id').val();
      console.log(Prenom_Employe+' '+Nom_Employe+' '+ Actif+' '+Couleur+' '+Initial+' '+action+' '+id);
      if(Nom_Employe != '' && Prenom_Employe != '' && Couleur != '') 
      {
       $.ajax({
        url : "Modele/ActionGestionEmploye.php",    
        method:"POST",     
        data:{id:id, Nom_Employe:Nom_Employe, Prenom_Employe:Prenom_Employe, Actif:Actif, Couleur:Couleur, Initial:Initial, action:action}, 
        success:function(data){
         BootstrapAlert(data);
         console.log(data);
         $('#customerModal').modal('hide'); 
         fetchUser();
       }
     });
     }
     else
     {
       alert("Tous les champs doivent être plein."); 
     }
   });

    $(document).on('click', '.update', function(){
      var id = $(this).attr("id"); 
      var action = "Select";
      $.ajax({
       url : "Modele/ActionGestionEmploye.php",   
       method:"POST",    
       data:{id:id, action:action},
       dataType:"json",   
       success:function(data){
        $('#customerModal').modal('show');   
        $('.modal-title').text("Mettre à jour"); 
        $('#action').val("Update");  

        if(data.Actif ==1)
$('#Actif').prop('checked', true);
          else
$('#Actif').prop('checked', false);
        
        $('#id').val(id); 
        $('#Prenom').val(data.Prenom);  
        $('#Nom').val(data.Nom); 
        $('#Couleur').val(data.Couleur);  
      }
    });
    });

    $(document).on('click', '.delete', function(){
      var id = $(this).attr("id"); 
      if(confirm("Es-tu sûr de vouloir supprimer cet(te) employé(e) ?")) 
      {
       var action = "Delete"; 
       $.ajax({
        url : "Modele/ActionGestionEmploye.php",    
        method:"POST",     
        data:{id:id, action:action}, 
        success:function(data)
        {
         fetchUser();    
         BootstrapAlert(data);
       }
     })
     }
     else  
     {
       return false; 
     }
   });

  });
</script>