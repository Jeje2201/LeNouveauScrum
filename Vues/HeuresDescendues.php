  <body class="fixed-nav sticky-footer" id="page-Result">
    <div class="content-wrapper">
      <div class="container">
        <div class="row">
          <div class="card col-md-12">
            <div class="card-header"><i class="fa fa-search" aria-hidden="true"></i> Sélection</div>
            <div class="card-body">
              <!-- Selectionner le sprint sur lequel l'on va jouer -->
              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-2">
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
                  <div class="col-md-3">
                    <select class="form-control"  id="numeroEmploye" name="numeroEmploye">
                      <option value="ToutLeMonde">*</option>
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

                  <div class="col-md-3">
                    <input type="text" name="DateAujourdhui" id='DateAujourdhui' class="form-control" />
                  </div>

                  <div class="col-md-4">
                    <button type="button" id="action" class="btn btn-info">Descendre</button>  
                  </div>
                  
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="row">

          <div class="card col-sm-6">
            <div class="card-header"><center>Tâche(s) en cours</center></div>
            <div class="card-body card-columns" id=EnCours>
            </div>
          </div>

          <div class="card col-sm-6">
            <div class="card-header"><center>Tâche(s) achevée(s)</center></div>
            <div class="card-body card-columns" id=Fini>
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
        $('#EnCours').html(data.Attribution); 
        $('#Fini').html(data.Descendue); 

        var action = "DateMinMax";
        $.ajax({
         url : "Modele/ActionDescendre2.php", 
         method:"POST", 
         data:{action:action, idAffiche:idAffiche}, 
         success:function(data){
          $('#DateAujourdhui').datetimepicker('setStartDate',data[0]);
          $('#DateAujourdhui').datetimepicker('setEndDate',data[1]);
        }
      });
      }
    });

    }

    $('#numeroSprint, #numeroEmploye').change(function(){
      fetchUser();
    });

    $('#action').click(function(){
      var action = "Descendre"
      var IdAttribue = [];
      var LeJourDeDescente = $('#DateAujourdhui').val()

      $('#Fini').find("div").find("div").find("input").each(function(){ 
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
  });

  $('#DateAujourdhui').datetimepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    minView : 2
  });

  function DeplaceToi(id) { 

    if($(id).parent().parent().parent().attr('id') == 'EnCours'){
      $(id).parent().parent().prependTo($("#Fini"));
      $(id).html('<i class="fa fa-arrow-left" aria-hidden="true">');
      
    }
    else{
     $(id).parent().parent().prependTo($("#EnCours"));
     $(id).html('<i class="fa fa-fw fa-arrow-right" aria-hidden="true">');
   }
 }

</script>