  <body class="fixed-nav sticky-footer" id="page-Result">
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="card col-md-12">
            <div class="card-body">
              <!-- Selectionner le sprint sur lequel l'on va jouer -->



      <div class="input-group mb-12">
        <div class="input-group-prepend">
          <span class="input-group-text">Sprint n°</span>
        </div>

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
<div class="input-group-prepend">
          <span class="input-group-text">Employé(e)</span>
        </div>
       <div id="ListeEmploye"></div>
<div class="input-group-prepend">
          <span class="input-group-text">Date</span>
        </div>
        <input type="text" name="DateAujourdhui" id='DateAujourdhui' class="form-control" />

        <button type="button" id="action" class="btn btn-info">Descendre</button>  

      </div>
            </div>

          </div>
        </div>

        <div class="row">

          <div class="card col-6">
            <div class="card-header"><center>Tâche(s) en cours</center></div>
            <div class="card-body card-columns" id=EnCours>
            </div>
          </div>

          <div class="card col-6">
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
<audio id="audio" src="Assets\Audio\Woosh.ogg" ></audio>
<script>

  $(document).ready(function(){

    var audio = document.getElementById("audio");

    $('#DateAujourdhui').text(ChoixDate("#DateAujourdhui",-1));

    RemplirListeEmploye();
    AfficherCards();

    function AfficherCards() 
    {
      var idAffiche = $('#numeroSprint').val();
      var idEmploye = $('#numeroEmploye').val();
      var action = "AfficherCards";
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

    function RemplirListeEmploye() 
    {
      var idAffiche = $('#numeroSprint').val();
      var action = "LoadListEmployes";
      $.ajax({
        url : "Modele/ActionDescendre2.php", 
        method:"POST",
        async: false,
        data:{action:action, idAffiche:idAffiche}, 
        success:function(data){
          $('#ListeEmploye').html(data.Attribution); 
        }
    });

    }


    $('#numeroSprint').change(function(){
      RemplirListeEmploye();
      AfficherCards();
      });

    $('#ListeEmploye').change(function(){
      AfficherCards();
    });

    $('#action').click(function(){
      var action = "Descendre"
      var IdAttribue = [];
      var LeJourDeDescente = $('#DateAujourdhui').val()

      $('#Fini').find(".BOUGEMOI").each(function(){ 
        IdAttribue.push($(this).attr('id'));
      });

      if(IdAttribue != '') 
      {
       $.ajax({
        url : "Modele/ActionDescendre2.php",    
        method:"POST",     
        data:{IdAttribue:IdAttribue, action:action, LeJourDeDescente:LeJourDeDescente}, 
        success:function(data){
         BootstrapAlert(data);
         AfficherCards();    
       }
     });
     }
     else
     {
       alert("Tu dois d'abord déplacer au moins une tâche de son emplacement \"en cours\" -> \"terminée.\""); 
     }

   });
  });

  $('#DateAujourdhui').datetimepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    minView : 2
  });

  function DeplaceToi(id) { 
   
    audio.play();
    
    if($(id).parent().attr('id') == 'EnCours'){
      $(id).prependTo($("#Fini"));
      $(id).addClass('border-danger')
      $(id).children().addClass('border-danger')
      
    }
    else{
     $(id).prependTo($("#EnCours"));
     $(id).removeClass('border-danger')
     $(id).children().removeClass('border-danger')
   }
 }

</script>