
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
            <div class="col-md-9">
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
            <div class="col-md-3" align="right">
              <button type="button" id="modal_button" class="btn btn-info">Créer un objectif</button>
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
        <label>Objectif</label>
        <input class="form-control" name="LabelObjectif" id="LabelObjectif" type="text" placeholder="Je suis un objectif.." >
        <br />
         <label>Etat</label>
        <form class="form-control" name="EtatObjectif" id="EtatObjectif">
          <?php
          $result = $conn->query("select id, nom from statutobjectif order by nom");
          while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $nom = $row['nom']; 
            echo '<input type="radio" name="Etat" id="EtatNum'.$id.'" value="'.$id.'"> '.$nom.'<br>';
          }
          ?>
        </form>
      </div>
      <div class="modal-footer">
        <input  name="id" id="id" />
        <input type="submit" name="action" id="action" class="btn btn-success" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

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
      var idAffiche = $('#numeroSprint').val();
      var action = "Load";
      $.ajax({
       url : "Modele/ActionObjectifs.php", 
       method:"POST", 
       data:{action:action, idAffiche:idAffiche}, 
       success:function(data){
        $('#result').html(data); 
      }
    });
    }

    $('#numeroSprint').change(function(){
      fetchUser();
    });

    $('#modal_button').click(function(){
      $('#customerModal').modal('show'); 
      $('.modal-title').text("Créer un objectif"); 
      $('#action').val('Créer'); 
      $('#EtatNum2').prop("checked", true);
    });

    $('#action').click(function(){
      var idSprint = $('#numeroSprint').val();
      var idProjet = $('#projetId').val();
      var LabelObjectif = $('#LabelObjectif').val();
      var EtatObjectif = $('input[name=Etat]:checked', '#EtatObjectif').val()
      var id = $('#id').val();
      var action = $('#action').val();  
      console.log(idSprint, idProjet,LabelObjectif,EtatObjectif);
      if(idSprint != '' && LabelObjectif != ''  && EtatObjectif != '' && idProjet != '') 
      {
       $.ajax({
        url : "Modele/ActionObjectifs.php",    
        method:"POST",     
        data:{id:id, idSprint:idSprint, LabelObjectif:LabelObjectif, EtatObjectif:EtatObjectif, idProjet:idProjet, action:action}, 
        success:function(data){
         BootstrapAlert(data);
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
       url : "Modele/ActionObjectifs.php",   
       method:"POST",    
       data:{id:id, action:action},
       dataType:"json",   
       success:function(data){
        console.log('ohmondieu:',data)
        $('#customerModal').modal('show');   
        $('.modal-title').text("Update Records"); 
        $('#action').val("Update");     
        $('#id').val(id); 
        $('#projetId').val(data.id_Projet);
        $('#LabelObjectif').text(data.objectif);
        $('#EtatNum'+data.id_StatutObjectif).prop("checked", true);
      }
    });
    });

    $(document).on('click', '.delete', function(){
      var id = $(this).attr("id"); 
      if(confirm("Es-tu sûr de vouloir supprimer ce sprint?")) 
      {
       var action = "Delete"; 
       $.ajax({
        url : "Modele/ActionObjectifs.php",    
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