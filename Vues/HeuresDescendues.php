  <body class="fixed-nav sticky-footer" id="page-Result">
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
          <div class="form-group">
            <select class="form-control"  id="numeroSprint" name="numeroSprint">
              <?php
              $result = $conn->query("select id, numero from sprint order by numero desc");

              while ($row = $result->fetch_assoc()) {
                unset($id, $numero);
                $id = $row['id'];
                $numero = $row['numero']; 
                echo '<option value="'.$id.'"> ' .$numero. ' </option>';
              }
              ?> 
            </select>
          </div>

          <div class="form-group">
            <select class="form-control"  id="numeroEmploye" name="numeroEmploye">
              <option value="DAMSON">*</option>
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
          </div>

          <div class="form-group">
            <input type="text" name="DateAujourdhui" id='DateAujourdhui' class="form-control" />
          </div>

          <div class="form-group">
            <button type="button" id="action" class="btn btn-info">Descendre</button>
          </div>

        </div>
        <br />

      </div>

      <div class="row">

        <div class="card col-sm-6">
          <div class="card-header"><center>Tâches En Cours</center></div>
          <div class="card-body card-columns" id=Top>
          </div>
        </div>

        <div class="card col-sm-6">
          <div class="card-header"><center>Tâches Terminées</center></div>
          <div class="card-body card-columns" id=Down>
          </div>
        </div>

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

    $('#DateAujourdhui').text(ChoixDate("#DateAujourdhui",-1));

    fetchUser();

    function fetchUser() 
    {
      var idAffiche = $('#numeroSprint').val();
      var idEmploye = $('#numeroEmploye').val();
      var action = "Load";
      $.ajax({
       url : "Modele/ActionDescendre2.php", 
       method:"POST", 
       data:{action:action, idAffiche:idAffiche, idEmploye:idEmploye}, 
       success:function(data){
        $('#Top').html(data.Attribution); 
        $('#Down').html(data.Descendue); 
      }
    });

    }

    $('#numeroSprint').change(function(){
      fetchUser();
    });

    $('#numeroEmploye').change(function(){
      fetchUser();
    });

    $('#action').click(function(){
      var action = "Descendre"
      var IdAttribue = [];
      var LeJourDeDescente = $('#DateAujourdhui').val()

      $('#Down').find("div").find("div").find("input").each(function(){ 
        IdAttribue.push($(this).val());
      });

      console.log('Tous les id a kill: ',IdAttribue)

      if(IdAttribue != '') 
      {
       $.ajax({
        url : "Modele/ActionDescendre2.php",    
        method:"POST",     
        data:{IdAttribue:IdAttribue, action:action, LeJourDeDescente:LeJourDeDescente}, 
        success:function(data){
         BootstrapAlert(data);
         fetchUser();    
       }
     });
     }
     else
     {
       alert("Tu dois d'abord déplacer au moins une tâche en cours dans tâche terminée."); 
     }

   });

    $(document).on('click', '.update', function(){
      var id = $(this).attr("id"); 
      var action = "Select";   
      $.ajax({
       url : "Modele/Modele/ActionDescendre2.php",   
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
        url : "Modele/Modele/ActionDescendre2.php",    
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

  $('#DateAujourdhui').datetimepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    minView : 2
  });

  function GoTop(id) { 
    $(id).parent().parent().appendTo($("#Top"));
    $(id).hide();
    $(id).next().show();
  };

  function GoDown(id) { 
    $(id).parent().parent().appendTo($("#Down"));
    $(id).hide();
    $(id).prev().show();
  };

</script>