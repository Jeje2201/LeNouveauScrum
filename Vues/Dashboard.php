<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <div class="content-wrapper">
   <div class="container-fluid">
    <div class="container-fluid">

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Sprint</div>
          <div class="card-body">
            <select class="form-control"  id="sprintIdList" onchange="Test($('#sprintIdList').val())">
              <?php

              $result = $conn->query("select id, numero from sprint order by numero desc");

              while ($row = $result->fetch_assoc()) {
                unset($id, $numero);
                $id = $row['id'];
                $numero = $row['numero']; 
                echo '<option value="'.$id.'">' .$numero. '</option>';
              }

              ?>
            </select>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-area-chart"></i> Total heures attribuées et descendues par employé(e)</div>
            <div class="card-body">
              <div id="HeureDescenduParEmploye"></div>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-area-chart"></i> Total heures attribuées et descendues par projet</div>
              <div class="card-body">
                <div id="HeureDescenduParProjet"></div>
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
          Test($('#sprintIdList').val());
        });


        function Test(NumeroduSprint){

          var action = "GetTotalHeuresDescenduesParEmploye";

          console.log('id du sprint: ',NumeroduSprint);

          $.ajax({
            url : "Modele/ActionDashboard.php", 
            method:"POST", 
            data:{action:action, NumeroduSprint:NumeroduSprint}, 
            success:function(hDescenduesParEmploye){

              console.log('du coup: ',hDescenduesParEmploye)
              
              hDescenduesParEmploye = JSON.parse(hDescenduesParEmploye);

              console.log(hDescenduesParEmploye);

              Highcharts.chart('HeureDescenduParEmploye', {
                chart: {
                  type: 'column'
                },
                title: {
                  text: ''
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


              Highcharts.chart('HeureDescenduParProjet', {
                chart: {
                  type: 'column'
                },
                title: {
                  text: ''
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
          });

        }





      </script>