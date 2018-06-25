  <body class="fixed-nav sticky-footer" id="page-top">
    <div class="content-wrapper">
      <div class="container">

        <div class="card">
          <div class="card-header"><b>Sprint</b></div>
          <div class="card-body">

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Sprint n°</span>
              </div>
              <input type="number" name="numero" id='numero' class="form-control">
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><span class="fa fa-calendar"></span>&nbsp; Date de Début</span>
              </div>
              <input type="text" name="dateDebut" id='dateDebut' class="form-control" />
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><span class="fa fa-calendar"></span>&nbsp; Date de Fin</span>
              </div>
             <input type="text" name="dateFin" id='dateFin' class="form-control" />
            </div>

            <div class="form-group">
              <button type="button" id="modal_button" class="btn btn-info">Créer un nouveau sprint</button>
              <!-- It will show Modal for Create new Records !-->
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>

  $(document).ready(function(){

    $('#dateDebut').text(ChoixDate("#dateDebut",0));
    $('#dateFin').text(ChoixDate("#dateFin",localStorage.getItem('NbJoursParSprint')));
    fetchUser(); 

    $('#dateDebut').datetimepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      minView : 2
    });
    $('#dateFin').datetimepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      minView : 2
    });
    function fetchUser() 
    {
      var action = "SprintMax";
      $.ajax({
       url : "Modele/ActionSprint.php", 
       method:"POST", 
       data:{action:action}, 
       success:function(data){
        data = data.replace(/\s+/g, '');
        $('#numero').val(data); 
      }
    });
    }
    $('#modal_button').click(function(){
      var numero = $('#numero').val(); 
      var dateDebut = $('#dateDebut').val(); 
      var dateFin = $('#dateFin').val();  
      var id = $('#id').val();
      var action = 'Créer'  
      if(numero != '' && dateDebut != '' && dateFin != '') 
      {
       $.ajax({
        url : "Modele/ActionSprint.php",    
        method:"POST",     
        data:{numero:numero, dateDebut:dateDebut, id:id, dateFin:dateFin, action:action}, 
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

  });
</script>