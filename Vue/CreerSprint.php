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

        <div class="form-row">
          <div class="col-md-9">
            <input class="form-control" id="BarreDeRecherche" type="text" placeholder="Rechercher..">
          </div>
          <div class="col-md-3" align="right">
            <button type="button" id="modal_button" class="btn btn-info">Créer nouveau sprint</button>
            <!-- It will show Modal for Create new Records !-->
          </div>

        </div>
        <div id="result" class="table-responsive"> <!-- Data will load under this tag!--></div>

      </div>
    </div>
  </body>
  </html>

  <!-- This is Customer Modal. It will be use for Create new Records and Update Existing Records!-->
  <div id="customerModal" class="modal fade">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <h4 class="modal-title">Create New Records</h4>
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
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
<?php require_once __Dir__ . '/footer.php'; ?>
<script>

  $(document).ready(function(){

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

    $("#BarreDeRecherche").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

 function fetchUser() // This function will fetch data from table and display under <div id="result">
 {
  var action = "Load";
  $.ajax({
   url : "../Modele/ActionSprint.php", //Request send to "ActionSprint.php page"
   method:"POST", //Using of Post method for send data
   data:{action:action}, //action variable data has been send to server
   success:function(data){
    $('#result').html(data); //It will display data under div tag with id result
  }
});
}

 //This JQuery code will Reset value of Modal item when modal will load for create new records
 $('#modal_button').click(function(){
  $('#customerModal').modal('show'); //It will load modal on web page
  $('.modal-title').text("Créer nouveau sprint"); //It will change Modal title to Create new Records
  $('#numero').val(parseInt(document.getElementById("datatable").rows[1].cells[0].innerHTML)+1); //This will clear Modal first name textbox
  $('#dateDebut').text(ChoixDate("#dateDebut",0));
  $('#dateFin').text(ChoixDate("#dateFin",14));
  $('#action').val('Create'); //This will reset Button value ot Create
});

 //This JQuery code is for Click on Modal action button for Create new records or Update existing records. This code will use for both Create and Update of data through modal
 $('#action').click(function(){
  var numero = $('#numero').val(); //Get the value of first name textbox.
  var dateDebut = $('#dateDebut').val(); //Get the value of last name textbox
  var dateFin = $('#dateFin').val();  //Get the value of hidden field customer id
  var id = $('#id').val();
  var action = $('#action').val();  //Get the value of Modal Action button and stored into action variable
  if(numero != '' && dateDebut != '' && dateFin != '') //This condition will check both variable has some value
  {
   $.ajax({
    url : "../Modele/ActionSprint.php",    //Request send to "ActionSprint.php page"
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

 //This JQuery code is for Update customer data. If we have click on any customer row update button then this code will execute
 $(document).on('click', '.update', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  var action = "Select";   //We have define action variable value is equal to select
  $.ajax({
   url : "../Modele/ActionSprint.php",   //Request send to "ActionSprint.php page"
   method:"POST",    //Using of Post method for send data
   data:{id:id, action:action},//Send data to server
   dataType:"json",   //Here we have define json data type, so server will send data in json format.
   success:function(data){
    $('#customerModal').modal('show');   //It will display modal on webpage
    $('.modal-title').text("Update Records"); //This code will change this class text to Update records
    $('#action').val("Update");     //This code will change Button value to Update
    $('#id').val(id);     //It will define value of id variable to this customer id hidden field
    $('#numero').val(data.numero);  //It will assign value to modal first name texbox
    $('#dateDebut').val(data.dateDebut);  //It will assign value of modal last name textbox
    $('#dateFin').val(data.dateFin);  //It will assign value of modal last name textbox
  }
});
});

 //This JQuery code is for Delete customer data. If we have click on any customer row delete button then this code will execute
 $(document).on('click', '.delete', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  if(confirm("Es-tu sûr de vouloir supprimer ce sprint?")) //Confim Box if OK then
  {
   var action = "Delete"; //Define action variable value Delete
   $.ajax({
    url : "../Modele/ActionSprint.php",    //Request send to "ActionSprint.php page"
    method:"POST",     //Using of Post method for send data
    data:{id:id, action:action}, //Data send to server from ajax method
    success:function(data)
    {
     fetchUser();    // fetchUser() function has been called and it will load data under divison tag with id result
     BootstrapAlert(data);
   }
 })
 }
  else  //Confim Box if cancel then 
  {
   return false; //No action will perform
 }
});
});


  </script>