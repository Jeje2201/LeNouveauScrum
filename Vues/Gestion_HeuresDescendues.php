  <body class="fixed-nav sticky-footer" id="page-top">
    <div class="content-wrapper">
      <div class="container">

        <div class="mb-3">
          <div class="form-row">
            <div class="col-md-10">
              <div id="ListSrint"></div>
            </div>
          </div>
          <br />

          <input class="form-control" id="BarreDeRecherche" type="text" placeholder="Rechercher..">

          <div id="TableauHeuresDescendues" class="table-responsive"></div>
          
        </div>
      </div>
    </body>
    </html>

    <div id="customerModal" class="modal fade">
     <div class="modal-dialog">
      <div class="modal-content">
       <div class="modal-header">
        <h4 class="modal-title">Tâche(s) achevée(s)</h4>
      </div>
      <div class="modal-body">
        <label>Employé</label>
        <select class="form-control" id="employeId" name="employeId">
          <?php
          $result = $conn->query("select id, prenom, nom from employe where employe.Actif = 1 order by prenom");
          while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $prenom = $row['prenom']; 
            $nom = $row['nom']; 
            echo '<option value="'.$id.'"> ' .$prenom. ' '.$nom.' </option>';
          }
          ?>
        </select>
        <br />
        <label>Projet</label>
        <select class="form-control"  id="projetId" name="projetId">
          <?php
          $result = $conn->query("select id, nom from projet order by nom");

          while ($row = $result->fetch_assoc()) {
            unset($id, $nom);
            $id = $row['id'];
            $nom = $row['nom']; 
            echo '<option value="'.$id.'"> ' .$nom. ' </option>';
          }
          ?>
        </select>
        <br />
        <label>Nombre d'heures</label>
        <input class="form-control" name="nbheure" id="nbheure" type="number" min="1" value="1">
        <br />
        <label>Date</label>
        <input type="text" name="DateAujourdhui" id='DateAujourdhui' class="form-control" />
        <br />
      </div>
      <div class="modal-footer">
        <input type="hidden" name="id" id="id" />
        <input type="submit" name="action" id="action" class="btn btn-success" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

  $(document).ready(function(){

    RemplirListSprint('ListSrint');
    ChargerTableau(); 
    BarreDeRecherche('BarreDeRecherche','TableauHeuresDescendues');
    
    function ChargerTableau() 
    {
      var idAffiche = $('#numeroSprint').val();
      var action = "Load";
      $.ajax({
       url : "Modele/ActionDescendre.php", 
       method:"POST", 
       data:{action:action, idAffiche:idAffiche}, 
       success:function(data){
        $('#TableauHeuresDescendues').html(data); 
      }
    });
    }

    $('#numeroSprint').change(function(){
      ChargerTableau();
    });

    $('#action').click(function(){
      var idSprint = $('#numeroSprint').val();
      var idEmploye = $('#employeId').val();
      var idProjet = $('#projetId').val();
      var NombreHeure = $('#nbheure').val();
      var DateAujourdhui = $('#DateAujourdhui').val();
      var id = $('#id').val();
      var action = $('#action').val();  
      if(idSprint != '' && idEmploye != '' && idProjet != '' && NombreHeure != '' && DateAujourdhui != '') 
      {
       $.ajax({
        url : "Modele/ActionDescendre.php",    
        method:"POST",     
        data:{id:id, DateAujourdhui:DateAujourdhui, idSprint:idSprint, idEmploye:idEmploye, idProjet:idProjet, NombreHeure:NombreHeure, action:action}, 
        success:function(data){
         BootstrapAlert(data);
         $('#customerModal').modal('hide'); 
         ChargerTableau();    
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
       url : "Modele/ActionDescendre.php",   
       method:"POST",    
       data:{id:id, action:action},
       dataType:"json",   
       success:function(data){
        $('#customerModal').modal('show');   
        $('.modal-title').text("Update Records"); 
        $('#action').val("Update");     
        $('#id').val(id); 
        $('#idSprint').val(data.id_Sprint);  
        $('#employeId').val(data.id_Employe);  
        $('#projetId').val(data.id_Projet);  
        $('#nbheure').val(data.heure);  
        $('#DateAujourdhui').val(data.DateAujourdhui);  
      }
    });
    });

    $(document).on('click', '.delete', function(){
      var id = $(this).attr("id"); 
      if(confirm("Es-tu sûr de vouloir supprimer ce sprint?")) 
      {
       var action = "Delete"; 
       $.ajax({
        url : "Modele/ActionDescendre.php",    
        method:"POST",     
        data:{id:id, action:action}, 
        success:function(data)
        {
         ChargerTableau();    
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

  $('#DateAujourdhui').datetimepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    minView : 2
  });

</script>