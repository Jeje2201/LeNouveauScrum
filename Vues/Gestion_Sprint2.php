  <body class="fixed-nav sticky-footer" id="page-top">
    <div class="content-wrapper">
      <div class="container">

        <div class="table-responsive">
          <table class="table table-bordered display" id="datatable1" width="100%">

            <thead>
              <tr>
                <th>Numero</th>
                <th>Début</th>
                <th>Fin</th>
                <th></th>
                <th>Editer</th>
              </tr>
            </thead>
          </table>
        </div>

      </div>
    </div>
  </body>
  </html>

  <!-- This is Customer Modal. It will be use for Create new Records and Update Existing Records!-->
  <div id="customerModal" class="modal fade">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <h4 class="modal-title">Nouveau sprint</h4>
    </div>
    <div class="modal-body">
      <label>Numero</label>
      <input type="number" name="numero" id='numero' class="form-control">
      <br />
      <label>Date Debut</label>
      <input type="text" name="dateDebut" id='dateDebut' class="form-control" />
      <br />
      <label>Date Fin</label>
      <input type="text" name="dateFin" id='dateFin' class="form-control" />
      <br />
    </div>
    <div class="modal-footer">
      <input type="hidden" name="id" id="id" />
      <input type="submit" name="action" id="action" class="btn btn-success" />
      <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
    </div>
  </div>
</div>
</div>
<script>

  $(document).ready(function(){

afficherTableau();
});
function afficherTableau(){
    var action = "TableauDeSprint2";

    $.ajax({
    url : "Modele/RequetesAjax.php", 
    method:"POST", 
    data:{action:action}, 
    success:function(data){

      data = data.replace(/}{/g, '},{');

      var objectStringArray = (new Function("return [" + data+ "];")());

      console.log(objectStringArray);

      var table = $('#datatable1').DataTable({
"bDestroy": true,
        data: objectStringArray,
        columns: [
        { data: 'numero' },
        { data: 'dateDebut' },
        { data: 'dateFin' },
        { data: 'id', "visible": false},
        {
          "data": null,
          "defaultContent": '<center><button class="Update">Update</button> <button class="Delete">Delete</button></center>',
          "targets": 2
        }
        ]

      } );

      $('#datatable1 tbody').on( 'click', 'button', function () {

        var action = this.className;

        var data = table.row( $(this).parents('tr') ).data();

        var id = data['id'];

        if (action=='Delete'){

          if(confirm("Es-tu sûr de vouloir supprimer ce sprint?")) 
          {
           var action = "Delete"; 
           $.ajax({
            url : "Modele/ActionSprint.php",    
            method:"POST",     
            data:{id:id, action:action}, 
            success:function(data)
            {
              afficherTableau();
             BootstrapAlert(data);
            }
           })
          }
          else  
          {
           return false; 
          }
        }

if(action == 'Update') {

  var action = "Select";   
  $.ajax({
   url : "Modele/ActionSprint.php",   
   method:"POST",    
   data:{id:id, action:action},
   dataType:"json",   
   success:function(data){
    $('#customerModal').modal('show');   
    $('.modal-title').text("Update Records"); 
    $('#action').val("Update");     
    $('#id').val(id);     
    $('#numero').val(data.numero);  
    $('#dateDebut').val(data.dateDebut);  
    $('#dateFin').val(data.dateFin); 
    afficherTableau();
  }
});

}

} );
    }

  });
    }

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

 
 $('#action').click(function(){
  var numero = $('#numero').val(); 
  var dateDebut = $('#dateDebut').val(); 
  var dateFin = $('#dateFin').val();  
  var id = $('#id').val();
  var action = $('#action').val();  
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

</script>