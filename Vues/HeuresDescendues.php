<body class="fixed-nav sticky-footer" id="page-Result">
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-6">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              Trier Sprint/Ressource
            </div>
            <div class="card-body">
              <!-- Selectionner le sprint sur lequel l'on va jouer -->

              <div class="input-group mb-12">
                <div class="input-group-prepend">
                  <span class="input-group-text">Sprint n°</span>
                </div>
                <div id="ListSrint"></div>
                
<!--                 <div class="input-group-prepend">
                  <span class="input-group-text">Employé(e)</span>
                </div>
                <div id="ListeEmploye"></div> -->

              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
           <div class="card-header">
            Valider les tâches
          </div>
          <div class="card-body">

            <div class="input-group mb-12">

              <div class="input-group-prepend">
                <span class="input-group-text">Date</span>
              </div>
              <input type="text" name="DateAujourdhui" id='DateAujourdhui' class="form-control" />

              <button type="button" id="action" class="btn btn-info">Descendre</button>

            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="row">
<div class="col-lg-6">
      <div class="card mb-3">
        <div class="card-header">
          <center>Tâche(s) en cours</center>
        </div>
        <div class="card-body card-columns" id=EnCours>
        </div>
      </div>
    </div>

<div class="col-lg-6">
      <div class="card mb-3">
        <div class="card-header">
          <center>Tâche(s) achevée(s)</center>
        </div>
        <div class="card-body card-columns" id=Fini>
        </div>
      </div>

    </div>
  </div>
  </div>
</body>

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

  $(document).ready(function () {

    $('#DateAujourdhui').datetimepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      minView: 2
    });

    RemplirListSprint('ListSrint')
    // RemplirListeEmploye();
    AfficherCards();

    function AfficherCards() {
      var idAffiche = $('#numeroSprint').val();
      var idEmploye = <?php echo $_SESSION['IdUtilisateur'] ?>;
      var action = "AfficherCards";
      $.ajax({
        url: "Modele/ActionDescendre2.php",
        method: "POST",
        data: { action: action, idAffiche: idAffiche, idEmploye: idEmploye },
        success: function (data) {
          $('#EnCours').html(data.Attribution);
          $('#Fini').html(data.Descendue);

          var action = "DateMinMax";
          $.ajax({
            url: "Modele/ActionDescendre2.php",
            method: "POST",
            data: { action: action, idAffiche: idAffiche },
            success: function (data) {
              $('#DateAujourdhui').datetimepicker('setStartDate', data[0]);
              $('#DateAujourdhui').datetimepicker('setEndDate', data[1]);

              if (ChoixDate(0) > data[0] && ChoixDate(0) < data[1]){
                console.log('Toujours dans Sprint, touche pas la date')
                $('#DateAujourdhui').val(ChoixDate(0));
              }
              else{
                console.log('aah plus dans le sprint, met la derniere date possible')
                $('#DateAujourdhui').val(data[0]);
              }
            }
          });
        }
      });
    }

    // function RemplirListeEmploye() {
    //   var idAffiche = $('#numeroSprint').val();
    //   var action = "LoadListEmployes";
    //   $.ajax({
    //     url: "Modele/ActionDescendre2.php",
    //     method: "POST",
    //     async: false,
    //     data: { action: action, idAffiche: idAffiche },
    //     success: function (data) {
    //       $('#ListeEmploye').html(data.Attribution);
    //     }
    //   });

    // }

    $('#numeroSprint').change(function () {
      // RemplirListeEmploye();
      AfficherCards();
    });

    // $('#ListeEmploye').change(function () {
    //   AfficherCards();
    // });

    $('#action').click(function () {
      var action = "Descendre"
      var IdAttribue = [];
      var LeJourDeDescente = $('#DateAujourdhui').val()

      $('#Fini').find(".BOUGEMOI").each(function () {
        IdAttribue.push($(this).attr('id'));
      });

      if (IdAttribue != '') {
        $.ajax({
          url: "Modele/ActionDescendre2.php",
          method: "POST",
          data: { IdAttribue: IdAttribue, action: action, LeJourDeDescente: LeJourDeDescente },
          success: function (data) {
            BootstrapAlert(data);
            AfficherCards();
          }
        });
      }
      else {
        alert("Tu dois d'abord déplacer au moins une tâche de son emplacement \"en cours\" -> \"terminée.\"");
      }

    });
  });

function DeplaceToi(id) {

    if ($(id).parent().attr('id') == 'EnCours') {
      $(id).prependTo($("#Fini"));
      $(id).addClass('border-warning')
      $(id).children().addClass('border-warning')

    }
    else {
      $(id).prependTo($("#EnCours"));
      $(id).removeClass('border-warning')
      $(id).children().removeClass('border-warning')
    }
  }

</script>