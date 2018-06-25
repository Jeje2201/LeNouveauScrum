<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <div class="content-wrapper">
   <div class="container-fluid">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Le Dashboard <a href="javascript:Test();">Imprimmer</a>  </li>
      </ol>


      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Total heures descendues par employé(e)</div>
          <div class="card-body">
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
                    <div class="col-sm-8 my-auto"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                    <canvas id="myBarChart" width="462" height="231" style="display: block; width: 462px; height: 231px;" class="chartjs-render-monitor"></canvas>
                  </div>
                  <div class="col-sm-4 text-center my-auto">
                    <div class="h4 mb-0 text-primary">$34,693</div>
                    <div class="small text-muted">YTD Revenue</div>
                    <hr>
                    <div class="h4 mb-0 text-warning">$18,474</div>
                    <div class="small text-muted">YTD Expenses</div>
                    <hr>
                    <div class="h4 mb-0 text-success">$16,219</div>
                    <div class="small text-muted">YTD Margin</div>
                  </div>
                </div>
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            <!-- /Card Columns-->
          </div>
          <div class="col-lg-7">
            <!-- Example Pie Chart Card-->
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-pie-chart"></i> Pie Chart Example</div>
                <div class="card-body">
                  <div id="container"></div>
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
        // misajour();//au lancement de la page, afficher la burndownchart avec le numero de la liste
      });


function Test(){


          var action = "GetTotalHeuresDescenduesParEmploye";

          $.ajax({
            url : "Modele/ActionDashboard.php", 
            method:"POST", 
            data:{action:action}, 
            success:function(yo){

              yo = JSON.parse(yo);

      Highcharts.chart('HeureDescenduParEmploye', {
        chart: {
          type: 'column'
        },
        title: {
          text: ''
        },
        xAxis: {
          type: 'category',
          categories: yo[0],
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
            text: 'Total d\'heure descendues'
          }
        },
        legend: {
          enabled: false
        },
        tooltip: {
          enabled: false
        },
        series: [{
          name:'Heure Descendues',
          data: yo[1],
          dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            y: 10, // 10 pixels down from the top
            style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
            }
          }
        }]
      });
    }
  });
        }


  </script>