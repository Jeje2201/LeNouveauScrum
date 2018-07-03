  <body class="fixed-nav sticky-footer" id="page-top">
    <div class="content-wrapper">
      <div class="container-fluid">

        <div class="card">
         <div class="card-header"><b>Créer sprint</b></div>
         <div class="card-body">
          <!-- Selectionner le sprint sur lequel l'on va jouer -->

          <div class="input-group">

            <div class="input-group-prepend">
              <span class="input-group-text">Sprint n°</span>
            </div>
            <input type="number" name="numero" id='numero' class="form-control">

            <div class="input-group-prepend">
              <span class="input-group-text"><span class="fa fa-calendar"></span>&nbsp;Début</span>
            </div>
            <input type="text" name="dateDebut" id='dateDebut' class="form-control" />

            <div class="input-group-prepend">
              <span class="input-group-text"><span class="fa fa-calendar"></span>&nbsp;Fin</span>
            </div>
            <input type="text" name="dateFin" id='dateFin' class="form-control" />

            <button type="button" id="modal_button" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i></button>

          </div>
        </div>

      </div>
      
              <div class="form-row">
          <div class="col-md-9">
            <input class="form-control" id="BarreDeRecherche" type="text" placeholder="Rechercher..">
          </div>

        </div>
        <div id="result" class="table-responsive table-hover"> <!-- Data will load under this tag!--></div>


  <!-- This is Customer Modal. It will be use for Create new Records and Update Existing Records!-->
  <div id="customerModal" class="modal fade">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <h4 class="modal-title">Nouveau sprint</h4>
    </div>
    <div class="modal-body">
      <label>Numero</label>
      <input type="number" name="numero" id='numeroo' class="form-control">
      <br />
      <label>Date Debut</label>
      <input type="text" name="dateDebut" id='dateDebutt' class="form-control" />
      <br />
      <label>Date Fin</label>
      <input type="text" name="dateFin" id='dateFinn' class="form-control" />
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

    </div>
  </div>
</div>
</body>
<script>

  $(document).ready(function(){

    $('#dateDebut').val(ChoixDate(0));
    $('#dateFin').val(ChoixDate(localStorage.getItem('NbJoursParSprint')));
    NumeroSprintMax();

    BarreDeRecherche('BarreDeRecherche','result');

    fetchUser(); //This function will load all data on web page when page load

     function fetchUser() // This function will fetch data from table and display under <div id="result">
 {
  var action = "Load";
  $.ajax({
   url : "Modele/ActionSprint.php", //Request send to "ActionSprint.php page"
   method:"POST", //Using of Post method for send data
   data:{action:action}, //action variable data has been send to server
   success:function(data){
    $('#result').html(data); //It will display data under div tag with id result
  }
});
}

    $('#dateDebut,#dateFin,#dateDebutt,#dateFinn').datetimepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      minView : 2
    });

    function NumeroSprintMax() 
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
      if(dateFin > dateDebut){
      if(numero != '' && dateDebut != '' && dateFin != '') 
      {
       $.ajax({
        url : "Modele/ActionSprint.php",    
        method:"POST",     
        data:{numero:numero, dateDebut:dateDebut, id:id, dateFin:dateFin, action:action}, 
        success:function(data){

         BootstrapAlert(data);
         NumeroSprintMax();
         fetchUser();

       }
     });
     }
     else
     {
       alert("Tous les champs doivent être plein."); 
     }
     }
     else{
       alert("La date de début est supérieure à celle de fin, comment tu veux que ça marche ?"); 
     }
   });


 //This JQuery code is for Update customer data. If we have click on any customer row update button then this code will execute
 $(document).on('click', '.update', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  var action = "Select";   //We have define action variable value is equal to select
  $.ajax({
   url : "Modele/ActionSprint.php",   //Request send to "ActionSprint.php page"
   method:"POST",    //Using of Post method for send data
   data:{id:id, action:action},//Send data to server
   dataType:"json",   //Here we have define json data type, so server will send data in json format.
   success:function(data){
    $('#customerModal').modal('show');   //It will display modal on webpage
    $('.modal-title').text("Changer infos sprint"); //This code will change this class text to Update records
    $('#action').val("Update");     //This code will change Button value to Update
    $('#id').val(id);     //It will define value of id variable to this customer id hidden field
    $('#numeroo').val(data.numero);  //It will assign value to modal first name texbox
    $('#dateDebutt').val(data.dateDebut);  //It will assign value of modal last name textbox
    $('#dateFinn').val(data.dateFin);  //It will assign value of modal last name textbox
  }
});
});

 $('#action').click(function(){
  var numero = $('#numeroo').val(); //Get the value of first name textbox.
  var dateDebut = $('#dateDebutt').val(); //Get the value of last name textbox
  var dateFin = $('#dateFinn').val();  //Get the value of hidden field customer id
  var id = $('#id').val();
  var action = $('#action').val();  //Get the value of Modal Action button and stored into action variable
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

 //This JQuery code is for Delete customer data. If we have click on any customer row delete button then this code will execute
 $(document).on('click', '.delete', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  if(confirm("Es-tu sûr de vouloir supprimer ce sprint?")) //Confim Box if OK then
  {
   var action = "Delete"; //Define action variable value Delete
   $.ajax({
    url : "Modele/ActionSprint.php",    //Request send to "ActionSprint.php page"
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