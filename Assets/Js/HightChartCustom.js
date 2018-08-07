function GetTotalHeuresAttribueDescendueProjetEmploye(NumeroduSprint, affichage, div) {

  var action = "GetTotalHeuresDescenduesParEmploye";

  $.ajax({
    url: "Modele/ActionDashboard.php",
    method: "POST",
    data: {
      action: action,
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {

      data = JSON.parse(data);

      console.log('Ressources qui ont des heures planifiés/descendues: ', data[0]);
      console.log('Total heures descendues par ressources: ', data[1]);
      console.log('Total heures planifiées par ressources: ', data[2]);
      console.log('Projets qui ont des heures planifiés/descendues: ', data[3]);
      console.log('Total heures descendues par projets: ', data[4]);
      console.log('Total heures planifiés par projets: ', data[5]);
      console.log('Etat et nombre d\'objectif: ', data[6]);
      console.log('Total heures planifiées toutes ressources comprises: ', data[7]);
      console.log('Total heures descendues toutes ressources comprises: ', data[8]);
      console.log('Total heures descendues toutes ressources comprises par jours: ', data[9]);
      console.log('Chaques jours qui ont des heures descendues: ', data[10]);
      console.log('Date de fin du sprint: ', data[11]);

      if (affichage == 1) {

        Highcharts.chart(div, {
          chart: {
            type: 'column'
          },
          title: {
            text: 'Total heures attribuées / descendues (triées par ressources)'
          },
          xAxis: {
            type: 'category',
            categories: data[0],
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
            data: data[2],
            pointPadding: 0.3,
          }, {
            name: 'Heures descendues',
            data: data[1],
            pointPadding: 0.4,
          }]
        });
      } else {

        Highcharts.chart(div, {
          chart: {
            type: 'column'
          },
          title: {
            text: 'Total heures attribuées / descendues (triées par projet)'
          },
          xAxis: {
            type: 'category',
            categories: data[3],
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
            data: data[5],
            pointPadding: 0.3
          }, {
            name: 'Heures descendues',
            data: data[4],
            pointPadding: 0.4
          }]
        });

      }

    }
  });

}

function GetTotalHeuresAttribueDescendue(NumeroduSprint, div) {

  var action = "GetTotalHeuresDescenduesParEmploye";

  $.ajax({
    url: "Modele/ActionDashboard.php",
    method: "POST",
    data: {
      action: action,
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {

      data = JSON.parse(data);

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
          data: data[7],
          pointPadding: 0.3,
        }, {
          name: 'Heures descendues',
          data: data[8],
          pointPadding: 0.4,
        }]
      });
    }
  })
}

function ChargerPieObjectif(NumeroduSprint, div) {

  var action = "GetTotalHeuresDescenduesParEmploye";

  $.ajax({
    url: "Modele/ActionDashboard.php",
    method: "POST",
    data: {
      action: action,
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {

      data = JSON.parse(data);
      var finalColors = data[6].map(o => o[2]);
      Highcharts.chart(div, {
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },
        colors: finalColors,
        title: {
          text: 'Etat des objectifs de la rétrospective'
        },
        tooltip: {
          pointFormat: '<b>{point.percentage:.1f}%</b>'
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
          name: ' ',
          data: data[6]
        }]
      });
    }
  });
}


function CreerLaBurnDownChart(heures, seuils, div, jours) {

  console.log("Données de la Burndownchart : ", heures, seuils, div, jours);

  heures = heures.map(function (x) {
    return parseInt(x);
  });

  seuils = seuils.map(function (x) {
    return parseInt(x);
  });

  if (seuils.length < jours.length)
    for (i = seuils.length; i < jours.length; i++) {
      seuils.push(seuils[0]);
    }


  new Highcharts.Chart({
    chart: {
      type: 'area',
      renderTo: div
    },
    title: {
      text: 'BurnDown Chart'
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
      categories: jours
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

function setInformation(idDiv, Information) {
  $("#" + idDiv).text(Information);
}

function fillInformation(infosource) {
  if (infosource[0][0] == null)
    setInformation('TotalHAttribues', 'Inconnue');
  else
    setInformation('TotalHAttribues', infosource[4]);

  setInformation('Seuil', parseInt(infosource[1][0]));

  if (typeof infosource[0][0] == 'undefined')
    setInformation('TotalHResteADescendre', 'Inconnue')
  else
    setInformation('TotalHResteADescendre', (infosource[0][infosource[0].length - 1]))

  if ((infosource[1][0] == null) || (typeof infosource[0][0] == 'undefined'))
    setInformation('TotalHDescendueAvecSeuil', 'Inconnue')
  else
    $("#TotalHDescendueAvecSeuil").text(((infosource[0][infosource[0].length - 1]) - (parseInt(infosource[1][0]))));

  if ((infosource[4][0] == null) || (typeof infosource[0][0] == 'undefined')) {
    $("#TotalHDescendue").text("Inconnue");
    $("#BarDePourcentageDheureDescendue").html("");
    $("#PourcentageDescendue").text("");

  } else {
    $("#TotalHDescendue").text((infosource[4] - infosource[0][infosource[0].length - 1]));

    if ((Math.round(((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]))) < 50)
      $("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: ' + ((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]) + '%; aria-valuenow="' + ((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]) + '" aria-valuemin="0" aria-valuemax="100"></div></div>');
    if ((Math.round(((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]))) >= 50 && (Math.round(((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]))) < 75)
      $("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: ' + ((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]) + '%; aria-valuenow="' + ((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]) + '" aria-valuemin="0" aria-valuemax="100"></div></div>');
    if ((Math.round(((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]))) >= 75)
      $("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: ' + ((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]) + '%; aria-valuenow="' + ((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4]) + '" aria-valuemin="0" aria-valuemax="100"></div></div>');

    $("#PourcentageDescendue").text(Math.round(((infosource[4] - infosource[0][infosource[0].length - 1]) * 100 / infosource[4])) + "%");
  }
}


function MettreChartAJour(NumeroSprint, div) {

  var action = "GetLesInfosDeLaBurnDownChart";

  $.ajax({
    url: "Modele/ActionBurnDownChart.php",
    method: "POST",
    data: {
      action: action,
      NumeroSprint: NumeroSprint
    },
    success: function (Total) {

      Total = JSON.parse(Total);

      CreerLaBurnDownChart(Total[0], Total[1], div, AjouterJourFrDevantDate(ListeJoursDate(Total[4], Total[5])));

      fillInformation(Total);

    }

  });

  idAffiche = parseInt($("#numeroSprint").val());
  var action = "DateMinMax";
  $.ajax({
    url: "Modele/ActionDescendre.php",
    method: "POST",
    data: {
      action: action,
      idAffiche: idAffiche
    },
    success: function (data) {

      $("#DateSprint").text(data[0] + " ->" + data[1])

      console.log('bonnes infos: ' + data[0][0] + ' -> ' + data[1][0])

      $("#NbJoursAFaire").text(NbJourDeTravail(data[0][0], data[1][0]))

      if (NbJourDeTravail(new Date().toJSON().slice(0, 10), data[1][0]) >= 0)
        $("#NbJoursRestants").text(NbJourDeTravail(new Date().toJSON().slice(0, 10), data[1][0]));

      else
        $("#NbJoursRestants").text("date dépassée");
    }
  });

};

function HeuresDescenduesParJours(NumeroduSprint, div) {

  var action = "GetTotalHeuresDescenduesParEmploye";

  $.ajax({
    url: "Modele/ActionDashboard.php",
    method: "POST",
    data: {
      action: action,
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {

      data = JSON.parse(data);

      var listeJoursDansSprint = ListeJoursDate(data[12][0], data[11][0])

      HeuresDescenduesParJoursSurToutLeSprint = new Array
      JoursOuvrableDejaPasse = new Array
      for (i = 0; i < listeJoursDansSprint.length; i++) {

        JourValide = 0

        for (y = 0; y < data[10].length; y++) {

          if (listeJoursDansSprint[i] == data[10][y]) {

            var JourValide = 1
            HeuresDescenduesParJoursSurToutLeSprint.push(data[9][y])
            JoursOuvrableDejaPasse.push(data[9][y])

          }

        }

        if (JourValide == 0) {

          if (DateFrToEn(listeJoursDansSprint[i]) > new Date().toJSON().split('T')[0])
            HeuresDescenduesParJoursSurToutLeSprint.push(null)

          else if (new Date(DateFrToEn(listeJoursDansSprint[i])).getDay() == 6 || new Date(DateFrToEn(listeJoursDansSprint[i])).getDay() == 0)
            HeuresDescenduesParJoursSurToutLeSprint.push(null)

          else {
            HeuresDescenduesParJoursSurToutLeSprint.push(0)
            JoursOuvrableDejaPasse.push(0)

          }

        }

      }

      MoyenneADescendre = new Array
      for (i = 0; i < listeJoursDansSprint.length; i++) {
        MoyenneADescendre.push(Math.round(data[7][0] / NbJourDeTravail(data[12][0], data[11][0])))
      }

      MoyenneDescendueTable = new Array
      for (i = 0; i < listeJoursDansSprint.length; i++) {
        MoyenneDescendueTable.push(Math.round(data[8] / JoursOuvrableDejaPasse.length))
      }


      new Highcharts.Chart({
        chart: {
          renderTo: div
        },
        title: {
          text: 'Heures descendues par jour <br>(toutes ressources comprises)'
        },
        // subtitle:{
        //   text: 'Déplace ta souris sur les points pour avoir plus de détails'
        // },
        yAxis: {
          min: 0,
          title: {
            text: 'Heures'
          },

        },
        xAxis: {
          type: 'datetime',
          categories: AjouterJourFrDevantDate(ListeJoursDate(data[12][0], data[11][0]))
        },
        plotOptions: {
          line: {
            dataLabels: {
              enabled: true
            },
            enableMouseTracking: true,
          }
        },
        series: [{
            name: 'Moyenne d\'heures descendues',
            data: MoyenneDescendueTable,
            color: '#c1c1c1',
            marker: false,
            enableMouseTracking: false,
            dataLabels: {
              enabled: false
            },
          }, {
            name: 'Moyenne d\'heures a descendre',
            data: MoyenneADescendre,
            color: '#4f4f4f',
            marker: false,
            enableMouseTracking: false,
            dataLabels: {
              enabled: false
            },
          }, {
            name: 'Heures descendues par jour',
            data: HeuresDescenduesParJoursSurToutLeSprint,
            zones: [{
                value: MoyenneADescendre[0],
                color: '#ff4747'
              },
              {
                color: '#00c652'
              }
            ]
          }

        ]
      });
    }
  });
}