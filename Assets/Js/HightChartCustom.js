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

            console.log('Toutes les infos a mettre dans les charts: ',hDescenduesParEmploye);

Highcharts.chart(div, {
              chart: {
                type: 'column'
              },
              title: {
                text: 'Total heures attribuées et descendues'
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

            console.log('Toutes les infos a mettre dans les charts: ',hDescenduesParEmploye);

            Highcharts.chart(div, {
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

      function CreerLaBurnDownChart(heures, dates, seuils, sprintou, NumeroduSprint, div){
        heures = heures.map(function (x) { 
          return parseInt(x, 10); 
        });

        seuils = seuils.map(function (x) { 
          return parseInt(x, 10); 
        });

        console.log("Les Informations : ",heures, dates, seuils, sprintou);

        new Highcharts.Chart({
          chart: {
            type: 'area',
            renderTo: div
          },
          title:{
            text: 'BurnDownChart du Sprint n°'+NumeroduSprint
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

          console.log(Total[2])

          CreerLaBurnDownChart(Total[0], Total[1], Total[2], Total[3], NumeroSprint, div);

          if (Total[4][0] == null)
            $("#TotalHAttribues").html("Total heures à descendre (h) : <b>Inconnue</b>");
          else
            $("#TotalHAttribues").html("Total heures à descendre (h) : <b>" + Total[4] + "</b>");

          $("#Seuil").html("Seuil (h) : <b>" + parseInt(Total[2][0]) + "</b>");

          if (typeof Total[0][0] == 'undefined')
            $("#TotalHResteADescendre").html("Heures restante à descendre : <b>Inconnue</b>");
          else
            $("#TotalHResteADescendre").html("Heures restante à descendre (h) : <b>" + (Total[0][Total[0].length - 1]) + "</b>");

          if ((Total[2][0] == null) || (typeof Total[0][0] == 'undefined'))
            $("#TotalHDescendueAvecSeuil").html("Heures restante à descendre (seuil) (h) : <b>Inconnue</b>");
          else
            $("#TotalHDescendueAvecSeuil").html("Heures restante à descendre (seuil) (h) : <b>" + ((Total[0][Total[0].length - 1]) - (parseInt(Total[2][0]))) + "</b>");

          if ((Total[4][0] == null) || (typeof Total[0][0] == 'undefined')) {
            $("#TotalHDescendue").html("Heures déjà descendues: <b>Inconnue</b>");
            $("#BarDePourcentageDheureDescendue").html("");
          }
          else {
            $("#TotalHDescendue").html("Heures déjà descendues (h) : <b>" + (Total[4] - Total[0][Total[0].length - 1]) + "</b>");
            $("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: ' + ((Total[4] - Total[0][Total[0].length - 1]) * 100 / Total[4]) + '%; aria-valuenow="' + ((Total[4] - Total[0][Total[0].length - 1]) * 100 / Total[4]) + '" aria-valuemin="0" aria-valuemax="100">' + Math.round(((Total[4] - Total[0][Total[0].length - 1]) * 100 / Total[4])) + '%</div></div>');
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

          $("#DateSprint").html("Date: <b>" + data[0] + "</b> > <b>" + data[1] + "</b>")

          if (data[1] > ChoixDate(0)) {

            Fin = new Date(data[1]);
            Aujourdui = new Date();
            $("#NbJoursRestants").html("Nombre de jours restants: <b>" + Math.ceil((Fin - Aujourdui) / (1000 * 60 * 60 * 24)) + "</b>");

          }
          else
            $("#NbJoursRestants").html("Nombre de jours restants: <b>date dépassée</b>");

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

            console.log('wow ',hDescenduesParEmploye);

        new Highcharts.Chart({
          chart: {
            renderTo: div
          },
          title:{
            text: 'Heures descendues par jour'
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
