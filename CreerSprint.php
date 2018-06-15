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

        <form>

          <div class="form-group">
            <label>Numero</label>
            <input type="number" name="numero" id='numero' class="form-control">
          </div>

          <div class="form-group">
            <label>Date Debut</label>
            <input type="text" name="dateDebut" id='dateDebut' class="form-control" />
          </div>

          <div class="form-group">
            <label>Date Fin</label>
            <input type="text" name="dateFin" id='dateFin' class="form-control" />
          </div>

          <div class="form-group">
            <button type="button" id="modal_button" class="btn btn-info">Créer nouveau sprint</button>
            <!-- It will show Modal for Create new Records !-->
          </div>

        </form>

        <div style="display: none" id="result" class="table-responsive"> <!-- Data will load under this tag!--></div>

      </div>
    </div>
  </body>
  </html>
<?php require_once __Dir__ . '/footer.php'; ?>
<script>

  $(document).ready(function(){

    $('#dateDebut').text(ChoixDate("#dateDebut",0));
    $('#dateFin').text(ChoixDate("#dateFin",localStorage.getItem('NbJoursParSprint')));


 fetchUser(); //This function will load all data on web page when page load

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


 function fetchUser() // This function will fetch data from table and display under <div id="result">
 {
  var action = "SprintMax";
  $.ajax({
   url : "Modele/ActionSprint.php", //Request send to "ActionSprint.php page"
   method:"POST", //Using of Post method for send data
   data:{action:action}, //action variable data has been send to server
   success:function(data){
    data = data.replace(/\s+/g, '');
    $('#numero').val(data); //It will display data under div tag with id result
  }
});
}

 //This JQuery code will Reset value of Modal item when modal will load for create new records
//  $('#modal_button').click(function(){
//   $('#customerModal').modal('show'); //It will load modal on web page
//   
// });

 //This JQuery code is for Click on Modal action button for Create new records or Update existing records. This code will use for both Create and Update of data through modal
 $('#modal_button').click(function(){
  var numero = $('#numero').val(); //Get the value of first name textbox.
  var dateDebut = $('#dateDebut').val(); //Get the value of last name textbox
  var dateFin = $('#dateFin').val();  //Get the value of hidden field customer id
  var id = $('#id').val();
  var action = 'Créer'  //Get the value of Modal Action button and stored into action variable
  if(numero != '' && dateDebut != '' && dateFin != '') //This condition will check both variable has some value
  {
   $.ajax({
    url : "Modele/ActionSprint.php",    //Request send to "ActionSprint.php page"
    method:"POST",     //Using of Post method for send data
    data:{numero:numero, dateDebut:dateDebut, id:id, dateFin:dateFin, action:action}, //Send data to server
    success:function(data){
     BootstrapAlert(data);
     $('#customerModal').modal('hide'); //It will hide Customer Modal from webpage.
     fetchUser();    // Fetch User function has been called and it will load data under divison tag with id result
   }
 });
 }
 else
 {
   alert("Tous les champs doivent être plein."); //If both or any one of the variable has no value them it will display this message
 }
});

});


</script>