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

            <div class="row">
              <div class="col-lg-5">
                <!-- Example Bar Chart Card-->
                <div class="card mb-3">
                  <div class="card-header">
                    <i class="fa fa-bar-chart"></i> Bar Chart Example</div>
                    <div class="card-body">
                      <div class="row">
                        <p>wow</p>
                  </div>
                </div>
              </div>
            </div>

              <div class="col-lg-7">
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
          RemplirListSprint('ListSrint') 
          Test($('#numeroSprint').val(),1);
        

         $('#numeroSprint').change(function(){
           Test($('#numeroSprint').val(),1);
          });

        $('#BoutonEmployes').click(function(){
          Test($('#numeroSprint').val(),1);
        });

        $('#BoutonProjets').click(function(){
          Test($('#numeroSprint').val(),2);
        });

        function Test(NumeroduSprint, affichage){

          var action = "GetTotalHeuresDescenduesParEmploye";

          $.ajax({
            url : "Modele/ActionDashboard.php", 
            method:"POST", 
            data:{action:action, NumeroduSprint:NumeroduSprint}, 
            success:function(hDescenduesParEmploye){
              
              hDescenduesParEmploye = JSON.parse(hDescenduesParEmploye);

              console.log('Toutes les infos a mettre dans les charts: ',hDescenduesParEmploye);

              if(affichage == 1){

              Highcharts.chart('HeureDescenduParEmploye', {
                chart: {
                  type: 'column'
                },
                title: {
                  text: 'Total heures attribuées et descendues'
                },
                xAxis: {
                  type: 'category',
                  categories: hDescenduesParEmploye[0],
                  labels: {
                    rotation: -45,
                    style: {
                      fontSize: '15px',
                      fontFamily: 'Verdana, sans-serif'
                    }
                  }
                },
                yAxis: {
                  min: 0,
                  title: {
                    text: 'Total heures attribuées et descendues'
                  }
                },
                tooltip: {
                  shared: true,
                },
                plotOptions: {
                  column: {
                    grouping: false,
                    shadow: true,
                    borderWidth: 1
                  },
                  dataLabels: {
                enabled: true,
                format: ''
            }
                },
                series: [{
                  name: 'Heures attribuées',
                  data: hDescenduesParEmploye[2],
                  pointPadding: 0.3,
                }, {
                  name: 'Heures descendues',
                  data: hDescenduesParEmploye[1],
                  pointPadding: 0.4,
                }]
              });
              }
              else{

              Highcharts.chart('HeureDescenduParEmploye', {
                chart: {
                  type: 'column'
                },
                title: {
                  text: 'Total heures attribuées et descendues'
                },
                xAxis: {
                  type: 'category',
                  categories: hDescenduesParEmploye[3],
                  labels: {
                    rotation: -45,
                    style: {
                      fontSize: '15px',
                      fontFamily: 'Verdana, sans-serif'
                    }
                  }
                },
                yAxis: {
                  min: 0,
                  title: {
                    text: 'Total heures attribuées et descendues'
                  }
                },
                tooltip: {
                  shared: true,
                },
                plotOptions: {
                  column: {
                    grouping: false,
                    shadow: true,
                    borderWidth: 1
                  }
                },
                series: [{
                  name: 'Heures attribuées',
                  data: hDescenduesParEmploye[5],
                  pointPadding: 0.3
                }, {
                  name: 'Heures descendues',
                  data: hDescenduesParEmploye[4],
                  pointPadding: 0.4
                }]
              });

              }

Highcharts.chart('PieChartStatueObjectif', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Statut objectifs'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'         
    },
    plotOptions: {
        pie: {

        colors: ['#95D972', '#E88648', '#E8514E', '#E8514E', '#222222'],
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y} ({point.percentage:.0f} %)'
            }
        }
    },
    series: [{
        name: 'Effectué',
        data: hDescenduesParEmploye[6]
    }]
});

            }
          });

        }
        });

      </script>