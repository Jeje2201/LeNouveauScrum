      function GetTotalHeuresAttribueDescendueProjetEmploye(NumeroduSprint, affichage, div){

        var action = "GetTotalHeuresDescenduesParEmploye";

        $.ajax({
          url : "Modele/ActionDashboard.php", 
          method:"POST", 
          data:{action:action, NumeroduSprint:NumeroduSprint}, 
          success:function(hDescenduesParEmploye){

            hDescenduesParEmploye = JSON.parse(hDescenduesParEmploye);

            console.log('Toutes les infos a mettre dans les charts: ',hDescenduesParEmploye);

            if(affichage == 1){

              Highcharts.chart(div, {
                chart: {
                  type: 'column'
                },
                title: {
                  text: 'Total heures attribuées / descendues (triées par ressources)'
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
                    text: 'Heures'
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

              Highcharts.chart(div, {
                chart: {
                  type: 'column'
                },
                title: {
                  text: 'Total heures attribuées / descendues (triées par projet)'
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
                    text: 'Heures'
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

          }
        });

      }

      function GetTotalHeuresAttribueDescendue(NumeroduSprint, div){

        var action = "GetTotalHeuresDescenduesParEmploye";

        $.ajax({
          url : "Modele/ActionDashboard.php", 
          method:"POST", 
          data:{action:action, NumeroduSprint:NumeroduSprint}, 
          success:function(hDescenduesParEmploye){

            hDescenduesParEmploye = JSON.parse(hDescenduesParEmploye);


Highcharts.chart(div, {
              chart: {
                type: 'column'
              },
              title: {
                text: 'Total heures attribuées/descendues<br>(toutes ressources comprises)'
              },
              yAxis: {
                min: 0,
                title: {
                  text: 'Heures'
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
                data: hDescenduesParEmploye[7],
                pointPadding: 0.3,
              }, {
                name: 'Heures descendues',
                data: hDescenduesParEmploye[8],
                pointPadding: 0.4,
              }]
            });
          }
        })
      }

      function ChargerPieObjectif(NumeroduSprint, div){

        var action = "GetTotalHeuresDescenduesParEmploye";

        $.ajax({
          url : "Modele/ActionDashboard.php", 
          method:"POST", 
          data:{action:action, NumeroduSprint:NumeroduSprint}, 
          success:function(hDescenduesParEmploye){

            hDescenduesParEmploye = JSON.parse(hDescenduesParEmploye);

            Highcharts.chart(div, {
              chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
              },
              colors: ['#95D972', '#E88648', '#E8514E', '#424242', '#5e005c'],
              title: {
                text: 'Etat des objectifs de la rétrospective'
              },
              tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'         
              },
              plotOptions: {
                pie: {

                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                    enabled: true,
                    format: '{point.name} ({point.y})'
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

      function CreerLaBurnDownChart(heures, dates, seuils, div){
        heures = heures.map(function (x) { 
          return parseInt(x, 10); 
        });

        seuils = seuils.map(function (x) { 
          return parseInt(x, 10); 
        });

        console.log("Données de la Burndownchart : ",heures, dates, seuils);

        new Highcharts.Chart({
          chart: {
            type: 'area',
            renderTo: div
          },
          title:{
            text: 'BurnDownChart'
          },
          // subtitle:{
          //   text: document.ontouchstart === undefined ?
          //   'Déplace ta souris sur les points pour avoir plus de détails': ''
          // },
          yAxis: {
            min: 0,
            title: {
              text: 'Heures'
            }
          },
          xAxis: {
            type: 'datetime',
            categories: dates
          },
          plotOptions: {
            area: {
            fillOpacity: 0.2
        },
            line: {
              dataLabels: {
                enabled: true
              },
              enableMouseTracking: true
            }
          },
          series: [{
            name: 'Heures Restantes',
            data: heures
          },
          {
            name: 'Seuil (Interventions, ...)',
            data: seuils
          }
          ]
        });
      };

          function MettreChartAJour(NumeroSprint, div) {

      var action = "GetLesInfosDeLaBurnDownChart";

      $.ajax({
        url: "Modele/ActionBurnDownChart.php",
        method: "POST",
        data: { action: action, NumeroSprint: NumeroSprint },
        success: function (Total) {
          Total = JSON.parse(Total);

          CreerLaBurnDownChart(Total[0], Total[1], Total[2], div);

          if (Total[4][0] == null)
            $("#TotalHAttribues").text("Inconnue");
          else
            $("#TotalHAttribues").text(Total[4]);

          $("#Seuil").text(parseInt(Total[2][0]));

          if (typeof Total[0][0] == 'undefined')
            $("#TotalHResteADescendre").text("Inconnue");
          else
            $("#TotalHResteADescendre").text((Total[0][Total[0].length - 1]));

          if ((Total[2][0] == null) || (typeof Total[0][0] == 'undefined'))
            $("#TotalHDescendueAvecSeuil").text("Inconnue");
          else
            $("#TotalHDescendueAvecSeuil").text(((Total[0][Total[0].length - 1]) - (parseInt(Total[2][0]))));

          if ((Total[4][0] == null) || (typeof Total[0][0] == 'undefined')) {
            $("#TotalHDescendue").text("Inconnue");
            $("#BarDePourcentageDheureDescendue").html("");
            $("#PourcentageDescendue").text("");

          }
          else {
            $("#TotalHDescendue").text((Total[4] - Total[0][Total[0].length - 1]));
            $("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: ' + ((Total[4] - Total[0][Total[0].length - 1]) * 100 / Total[4]) + '%; aria-valuenow="' + ((Total[4] - Total[0][Total[0].length - 1]) * 100 / Total[4]) + '" aria-valuemin="0" aria-valuemax="100"></div></div>');
          $("#PourcentageDescendue").text( Math.round(((Total[4] - Total[0][Total[0].length - 1]) * 100 / Total[4])) + "%");
          }
        }

      });

      idAffiche = parseInt($("#numeroSprint").val());
      var action = "DateMinMax";
      $.ajax({
        url: "Modele/ActionDescendre2.php",
        method: "POST",
        data: { action: action, idAffiche: idAffiche },
        success: function (data) {

          $("#DateSprint").text(data[0] + " ->" + data[1])

          if (data[2] > 0) {

            
            $("#NbJoursRestants").text(data[2]);

          }
          else
            $("#NbJoursRestants").text("date dépassée");

        }
      });

    };

      function HeuresDescenduesParJours(NumeroduSprint, div){
       
        var action = "GetTotalHeuresDescenduesParEmploye";

        $.ajax({
          url : "Modele/ActionDashboard.php", 
          method:"POST", 
          data:{action:action, NumeroduSprint:NumeroduSprint}, 
          success:function(hDescenduesParEmploye){

            hDescenduesParEmploye = JSON.parse(hDescenduesParEmploye);

        new Highcharts.Chart({
          chart: {
            renderTo: div
          },
          title:{
            text: 'Heures descendues par jour <br>(toutes ressources comprises)'
          },
          // subtitle:{
          //   text: 'Déplace ta souris sur les points pour avoir plus de détails'
          // },
          yAxis: {
            min: 0,
            title: {
              text: 'Heures'
            }
          },
          xAxis: {
            type: 'datetime',
            categories: hDescenduesParEmploye[10]
          },
          plotOptions: {
            line: {
              dataLabels: {
                enabled: true
              },
              enableMouseTracking: true
            }
          },
          series: [{
            name: 'Heures Restantes',
            data: hDescenduesParEmploye[9]
          }
          ]
        });
      }
    });
      }
