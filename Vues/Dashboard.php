<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <div class="content-wrapper">
   <div class="container-fluid">
    <div class="container-fluid">

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Sprint</div>
          <div class="card-body">
            <div id="ListSrint"></div>
          </div>
        </div>

<div class="row">
          <div class="col-lg-3">
        <div class="card mb-3">
          <div class="card-body">
            <div id="TotalHattribueDescendue">Hey</div>
          </div>
        </div>
      </div>
                <div class="col-lg-9">
        <div class="card mb-3">
          <div class="card-body">

            <center>
              <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" id="BoutonEmployes" class="btn btn-warning update">Employés</button>
                <button type="button" id="BoutonProjets" class="btn btn-danger delete">Projets</button>
              </div>
            </center>
           <div id="HeureDescenduParEmploye"></div>
          </div>
        </div>
      </div>
    </div>

        <div class="row">
          <div class="col-lg-7">
            <!-- Example Bar Chart Card-->
            <div class="card mb-3">
                <div class="card-body">
                  <div id="HeureDescenduesParJours"></div>
                </div>
              </div>
            </div>

            <div class="col-lg-5">
              <!-- Example Pie Chart Card-->
              <div class="card mb-3">
                <div class="card-body">
                  <div id="PieChartStatueObjectif"></div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </body>

  <script>

    $( document ).ready(function() {

      RemplirListSprint('ListSrint');
      GetTotalHeuresAttribueDescendueProjetEmploye($('#numeroSprint').val(),1,'HeureDescenduParEmploye');
      ChargerPieObjectif($('#numeroSprint').val(),'PieChartStatueObjectif');
      GetTotalHeuresAttribueDescendue($('#numeroSprint').val(),'TotalHattribueDescendue');
      HeuresDescenduesParJours($('#numeroSprint').val(),'HeureDescenduesParJours')

      $('#numeroSprint').change(function(){
       GetTotalHeuresAttribueDescendueProjetEmploye($('#numeroSprint').val(),1,'HeureDescenduParEmploye');
       ChargerPieObjectif($('#numeroSprint').val(),'PieChartStatueObjectif');
       GetTotalHeuresAttribueDescendue($('#numeroSprint').val(),'TotalHattribueDescendue');
       HeuresDescenduesParJours($('#numeroSprint').val(),'HeureDescenduesParJours')
     });

      $('#BoutonEmployes').click(function(){
        GetTotalHeuresAttribueDescendueProjetEmploye($('#numeroSprint').val(),1,'HeureDescenduParEmploye');
      });

      $('#BoutonProjets').click(function(){
        GetTotalHeuresAttribueDescendueProjetEmploye($('#numeroSprint').val(),2,'HeureDescenduParEmploye');
      });

});

</script>