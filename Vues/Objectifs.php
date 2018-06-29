
<body class="fixed-nav sticky-footer" id="page-top">
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="card col-md-12">
        <div class="card-header"><i class="fa fa-search" aria-hidden="true"></i> Sélection</div>
        <div class="card-body">
          <!-- Selectionner le sprint sur lequel l'on va jouer -->
          <div class="form-group">
            <div class="form-row">
              <div class="col-sm-3">
                <div id="ListSrint"></div>
              </div>

              <div class="col-sm-2">
               <button type="button" id="modal_button" class="btn btn-info btn-block">Objectif</button>
             </div>

             <div class="col-sm-3">
              <button type="button" id="Bouttonretrospective" class="btn btn-info btn-block">Rétrospective</button>
            </div>

            <div class="col-sm-3">
              <button type="button" id="BouttonImprimmer" class="btn btn-info btn-block">Imprimer</button>
            </div>

          </div>
        </div>
      </div>

    </div>

    <br>

    <div id="TableObjectif" class="table-responsive"></div>

    <div id="TableRetrospective" class="table-responsive"></div>

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
    <div id="ListProjet"> </div>
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
    <input type="hidden" name="id" id="id" />
    <input type="submit" name="action" id="action" class="btn btn-success" />
    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
  </div>
</div>
</div>
</div>

<div id="Modalretrospective" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Remarque</h4>
  </div>
  <div class="modal-body">
    <input class="form-control" name="Labelretrospective" id="Labelretrospective" type="text" placeholder="Je suis une rétrospective.." >
  </div>
  <div class="modal-footer">
    <input type="submit" name="CreerRetrospective" id="CreerRetrospective" class="btn btn-success" />
    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
  </div>
</div>
</div>
</div>

<script>

  $(document).ready(function(){

     RemplirListSprint('ListSrint');

    RemplirListProjet('ListProjet');

    RemplirTableau(); 

    function RemplirTableau() 
    {
      var idAffiche = $('#numeroSprint').val();
      var action = "Load";
      $.ajax({
       url : "Modele/ActionObjectifs.php", 
       method:"POST", 
       data:{action:action, idAffiche:idAffiche}, 
       success:function(data){
        $('#TableObjectif').html(data); 
      }
    });

      var action = "retrospective";
      $.ajax({
       url : "Modele/ActionObjectifs.php", 
       method:"POST", 
       data:{action:action}, 
       success:function(data){
        $('#TableRetrospective').html(data); 
      }
    });

    }

    $('#numeroSprint').change(function(){
      RemplirTableau();
      $('td:nth-child(4),th:nth-child(4)').hide();
    });

    $('#modal_button').click(function(){
      $('#customerModal').modal('show'); 
      $('.modal-title').text("Créer un objectif"); 
      $('#action').val('Créer');
      $('#LabelObjectif').val("");
      $('#EtatNum5').prop("checked", true);
    });

    $('#Bouttonretrospective').click(function(){
      $('#Modalretrospective').modal('show'); 
      $('.modal-title').text("Créer une rétrospective"); 
      $('#Labelretrospective').val("");
      $('#EtatNum5').prop("checked", true);
    });

    $('#action').click(function(){
      var idSprint = $('#numeroSprint').val();
      var idProjet = $('#projetId').val();
      var LabelObjectif = $('#LabelObjectif').val();
      var EtatObjectif = $('input[name=Etat]:checked', '#EtatObjectif').val()
      var id = $('#id').val();
      var action = $('#action').val();  
      if(idSprint != '' && LabelObjectif != ''  && EtatObjectif != '' && idProjet != '') 
      {
       $.ajax({
        url : "Modele/ActionObjectifs.php",    
        method:"POST",     
        data:{id:id, idSprint:idSprint, LabelObjectif:LabelObjectif, EtatObjectif:EtatObjectif, idProjet:idProjet, action:action}, 
        success:function(data){
         BootstrapAlert(data);
         $('#customerModal').modal('hide'); 
         RemplirTableau();    
       }
     });
     }
     else
     {
       alert("Tous les champs doivent être plein."); 
     }
   });

    $('#CreerRetrospective').click(function(){

      var Labelretrospective = $('#Labelretrospective').val();
      var action = "CréerRetrospective";  
      if(Labelretrospective != '') 
      {
       $.ajax({
        url : "Modele/ActionObjectifs.php",    
        method:"POST",     
        data:{Labelretrospective:Labelretrospective, action:action}, 
        success:function(data){
         BootstrapAlert(data);
         $('#Modalretrospective').modal('hide'); 
         RemplirTableau();    
       }
     });
     }
     else
     {
       alert("Tous les champs doivent être plein."); 
     }
   });

    $(document).on('click', '.success', function(){
      var id = $(this).attr("id"); 
      var action = "retrospectiveFini";   
      $.ajax({
       url : "Modele/ActionObjectifs.php",   
       method:"POST",
       data:{id:id, action:action},
       success:function(data){
        BootstrapAlert(data);
        RemplirTableau();
      }
    });
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
        $('#customerModal').modal('show');   
        $('.modal-title').text("Editer objectif"); 
        $('#action').val("Changer");
        $('#id').val(id); 
        $('#projetId').val(data.id_Projet);
        $('#LabelObjectif').val(data.objectif);
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
         RemplirTableau();    
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

$('#BouttonImprimmer').click(function(){

  $('#TableObjectif th:nth-child(4)').remove();
  $('#TableObjectif td:nth-child(4)').remove();

  $('#TableRetrospective th:nth-child(3)').remove();
  $('#TableRetrospective td:nth-child(3)').remove();

  var doc = new jsPDF('landscape');

  doc.setFontSize(30);
  doc.text(20, 20, 'Les objectifs');

  doc.fromHTML($('#TableObjectif').get(0),20,20,{
  });

  doc.addPage();

  doc.setFontSize(30);
  doc.text(20, 20, 'Les retrospectives');

  doc.fromHTML($('#TableRetrospective').get(0),20,20,{
      // 'width':500
    });

  doc.save('Sprint n°'+$('#numeroSprint option:selected').text() +'.pdf');

  location.reload();
  
});
</script>