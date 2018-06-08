  <html>
  <?php include('header.php'); ?>
  <body class="fixed-nav sticky-footer" id="page-top">
    <div class="content-wrapper">
      <div class="container">
        <div class="alert alert-success"  style="display: none" role="alert"> </div>
        <div class="mb-3">
          <div class="form-row">
            <div class="col-md-10">
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
         <div class="col-md-2" align="right">
          <button type="button" id="modal_button" class="btn btn-info">Attribuer</button>
          <!-- It will show Modal for Create new Records !-->
        </div>
      </div>
        <br />

        <input class="form-control" id="BarreDeRecherche" type="text" placeholder="Rechercher..">

        <div id="result" class="table-responsive"> <!-- Data will load under this tag!--></div>

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
    <h4 class="modal-title">Create New Records</h4>
  </div>
  <div class="modal-body">
    <label>Employé</label>
    <select class="form-control" id="employeId" name="employeId">
      <?php
      $result = $conn->query("select id, prenom, nom from employe order by prenom");
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
  </div>
  <div class="modal-footer">
    <input  type="hidden" name="id" id="id" />
    <input type="submit" name="action" id="action" class="btn btn-success" />
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>
</div>
</div>

<?php require_once __Dir__ . '/footer.php'; ?>

<script>

  $(document).ready(function(){

    $("#BarreDeRecherche").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

 fetchUser(); //This function will load all data on web page when page load

 function fetchUser() // This function will fetch data from table and display under <div id="result">
 {
  var idAffiche = $('#numeroSprint').val();
  var action = "Load";
  $.ajax({
   url : "ActionAttributionHeure.php", //Request send to "ActionAttributionHeure.php page"
   method:"POST", //Using of Post method for send data
   data:{action:action, idAffiche:idAffiche}, //action variable data has been send to server
   success:function(data){
    $('#result').html(data); //It will display data under div tag with id result
  }
});
}

 $('#numeroSprint').change(function(){
  fetchUser();
});

 //This JQuery code will Reset value of Modal item when modal will load for create new records
 $('#modal_button').click(function(){
  $('#customerModal').modal('show'); //It will load modal on web page
  $('.modal-title').text("Attribuer"); //It will change Modal title to Create new Records
  $('#action').val('Create'); //This will reset Button value ot Create
});

 //This JQuery code is for Click on Modal action button for Create new records or Update existing records. This code will use for both Create and Update of data through modal
 $('#action').click(function(){
  var idSprint = $('#numeroSprint').val();
  var idEmploye = $('#employeId').val();
  var idProjet = $('#projetId').val();
  var NombreHeure = $('#nbheure').val();
  var id = $('#id').val();
  var action = $('#action').val();  //Get the value of Modal Action button and stored into action variable
  if(idSprint != '' && idEmploye != '' && idProjet != '' && NombreHeure != '') //This condition will check both variable has some value
  {
   $.ajax({
    url : "ActionAttributionHeure.php",    //Request send to "ActionAttributionHeure.php page"
    method:"POST",     //Using of Post method for send data
    data:{id:id, idSprint:idSprint, idEmploye:idEmploye, idProjet:idProjet, NombreHeure:NombreHeure, action:action}, //Send data to server
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
   url:"ActionAttributionHeure.php",   //Request send to "ActionAttributionHeure.php page"
   method:"POST",    //Using of Post method for send data
   data:{id:id, action:action},//Send data to server
   dataType:"json",   //Here we have define json data type, so server will send data in json format.
   success:function(data){
    $('#customerModal').modal('show');   //It will display modal on webpage
    $('.modal-title').text("Update Records"); //This code will change this class text to Update records
    $('#action').val("Update");     //This code will change Button value to Update
    $('#id').val(id); 
    $('#idSprint').val(data.idSprint);  //It will assign value to modal first name texbox
    $('#employeId').val(data.id_Employe);  //It will assign value to modal first name texbox
    $('#projetId').val(data.id_Projet);  //It will assign value of modal last name textbox
    $('#nbheure').val(data.heure);  //It will assign value of modal last name textbox
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
    url:"ActionAttributionHeure.php",    //Request send to "ActionAttributionHeure.php page"
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

  function BootstrapAlert(message){
    $('.alert').text(message);
    $('.alert').show();
    $('.alert').delay(2000).fadeOut('slow');
  }
</script>