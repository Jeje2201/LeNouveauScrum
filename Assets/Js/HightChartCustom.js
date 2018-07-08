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
