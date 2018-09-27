/**
 * @param {number} NumeroduSprint - Numéro du sprint
 * @param {number} affichage - Si affichage = 0, afficher ressources, sinon afficher projet
 * @param {string} div - Nom du div qui va prendre la chart
 */
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
      try{
      data = JSON.parse(data);
    } catch (e) {
      console.log(e)
      console.log('ya un probleme :', data)
    }

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
            categories: data['NomRessource'],
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
              stacking: 'normal',
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
            data: data['RessourceHeureAttribuees'],
            stack: 0,
            pointPadding: 0.3,
          },{
            name: 'Heures Interférences',
            data: data['RessourceHeureInterference'],
            stack: 1,
            color: '#ca2ff9',
            pointPadding: 0.4,
          }, {
            name: 'Heures descendues',
            data: data['RessourceHeuresDescendues'],
            stack: 1,
            color: 'black',
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
            categories: data['NomProjet'],
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
              stacking: 'normal',
              grouping: false,
              shadow: true,
              borderWidth: 1
            }
          },
          series: [{
            name: 'Heures attribuées',
            data: data['ProjetHeuresAttribuees'],
            stack: 0,
            pointPadding: 0.3
          },
          {
            name: 'Heures interference',
            data: data['ProjetHeuresInterferences'],
            stack: 1,
            color: '#ca2ff9',
            pointPadding: 0.4
          }, {
            name: 'Heures descendues',
            data: data['ProjetHeuresDescendues'],
            stack: 1,
            color: 'black',
            pointPadding: 0.4
          }
          ]
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

      try{
        data = JSON.parse(data);
      } catch (e) {
        console.log(e)
        console.log('ya un probleme :', data)
      }

      Highcharts.chart(div, {
        chart: {
          type: 'column'
        },
        title: {
          text: 'Total heures attribuées/descendues<br>(toutes ressources comprises)'
        },
        yAxis: {
          title: {
            text: 'Heures'
          }
        },
        tooltip: {
          shared: true,
        },
        plotOptions: {
          column: {
            stacking: 'normal',
            grouping: false
        },
          dataLabels: {
            enabled: true
          }
        },
        series: [
          {
          name: 'Heures attribuées',
          data: data['TotalHeuresAttribuees'],
          stack: 0,
          pointPadding: 0.3
        },
        {
          name: 'Heures interférence',
          color: 'rgba(126,86,134,.9)',
          data: data['TotalHeuresInterference'],
          stack: 1,
          pointPadding: 0.4
        }, 
        {
          name: 'Heures descendues',
          data: data['TotalHeuresDescendues'],
          stack: 1,
          pointPadding: 0.4
        },
        
      ]
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

      try{
        data = JSON.parse(data);
      } catch (e) {
        console.log(e)
        console.log('ya un probleme :', data)
      }
      var finalColors = data['Objectifs'].map(o => o[2]);
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
          data: data['Objectifs']
        }]
      });
    }
  });
}

/**
 * Création de la burndownchart, utilisé qu'une fois
 * @param {object} heures - Tableau représentant les heures descendues
 * @param {number} seuils - Int représentant le seuil 
 * @param {string} div - String représentant le nom du div dans lequel va la bundownchart 
 * @param {object} jours - Array avec les jours qui ont des heures descendues
 */
function CreerLaBurnDownChart(heures, seuils, div, jours) {

  heures = heures.map(function (x) {
    return parseInt(x);
  });


  var tableauSeuil = new Array
  for (i = 0; i < jours.length; i++) {
    tableauSeuil.push(seuils);
  }

  new Highcharts.Chart({
    chart: {
      type: 'area',
      renderTo: div
    },
    title: {
      text: 'BurnDown Chart'
    },
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
        name: 'Seuil (interférence, congé, ...)',
        data: tableauSeuil
      }
    ]
  });
};

/**
 * Permet de set du text a un div passé en parametre
 * @param {string} idDiv - La div a modifié
 * @param {string} Information - Le texte a mettre dans le div
 */
function setInformation(idDiv, Information) {
  $("#" + idDiv).text(Information);
}

/**
 * Fonction pour remplir les textes a coté de la burbndown chart
 * @param {Array} infosource - Tableau avec toutes les valeurs de la burndown chart
 */
function fillInformation(infosource) {

  console.log(infosource)

  if (infosource['TotalADescendre'] > 0)
    setInformation('TotalHAttribues', infosource['TotalADescendre']);
  else
    setInformation('TotalHAttribues', '?');

  if (infosource['Interference'] > 0)
    setInformation('Seuil', parseInt(infosource['Interference']));
  else
    setInformation('Seuil', '?');

  if (infosource['HeuresDesJours'][0] > 0)
    setInformation('TotalHResteADescendre', (infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]))
  else
    setInformation('TotalHResteADescendre', '?')

  if ((infosource['Interference'] > 0) || (infosource['HeuresDesJours'][0] > 0))
    $("#TotalHDescendueAvecSeuil").text(((infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) - (parseInt(infosource['Interference']))));
  else
    setInformation('TotalHDescendueAvecSeuil', '?')

  if ((infosource['TotalADescendre'] > 0) && (infosource['HeuresDesJours'][0] > 0)) {

    $("#TotalHDescendue").text((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]));

    if ((Math.round(((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']))) < 50)
      $("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: ' + ((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']) + '%; aria-valuenow="' + ((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']) + '" aria-valuemin="0" aria-valuemax="100"></div></div>');

    if ((Math.round(((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']))) >= 50 && (Math.round(((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']))) < 75)
      $("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: ' + ((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']) + '%; aria-valuenow="' + ((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']) + '" aria-valuemin="0" aria-valuemax="100"></div></div>');

    if ((Math.round(((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']))) >= 75)
      $("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: ' + ((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']) + '%; aria-valuenow="' + ((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre']) + '" aria-valuemin="0" aria-valuemax="100"></div></div>');

    $("#PourcentageDescendue").text(Math.round(((infosource['TotalADescendre'] - infosource['HeuresDesJours'][infosource['HeuresDesJours'].length - 1]) * 100 / infosource['TotalADescendre'])) + "%");

  } else {
    $("#TotalHDescendue").text("0");
    $("#BarDePourcentageDheureDescendue").html(" ?");
    $("#PourcentageDescendue").text("");
  }
}

/**
 * Création / mettre a jours les infos de la burndownchart
 * @param {number} NumeroSprint - Int numéro du sprint en cours
 * @param {string} div - String div dans lequel mettre la burndownchart
 */
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

      try{
        Total = JSON.parse(Total);
      } catch (e) {
        console.log(e)
        console.log('ya un probleme :', Total)
      }

      CreerLaBurnDownChart(FusionnerJoursEtHeuresBurndDownChart(Total['DateDebut'], Total['DateFin'], Total['JoursAvecDesHeures'], Total['HeuresDesJours'], Total['TotalADescendre']), Total['Interference'], div, AjouterJourFrDevantDate(ListeJoursDate(Total['DateDebut'], Total['DateFin'])));

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

      $("#DateSprint").text(data['DateMin'] + " ->" + data['DateMax'])

      $("#NbJoursAFaire").text(NbJourDeTravail(data['DateMin'][0], data['DateMax'][0]))

      if (NbJourDeTravail(new Date().toJSON().slice(0, 10), data['DateMax'][0]) >= 0)
        $("#NbJoursRestants").text(NbJourDeTravail(new Date().toJSON().slice(0, 10), data['DateMax'][0]));
      else
        $("#NbJoursRestants").text("date dépassée");

    }
  });

};

/**
 * Permet d'afficher la chart avec les heures descendues par jour par les ressources, la moyenne de combien il aurait fallu descendre et combien en moyenne ils ont descendu
 * @param {number} NumeroduSprint 
 * @param {string} div 
 */
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

      try{
        data = JSON.parse(data);
      } catch (e) {
        console.log(e)
        console.log('ya un probleme :', data)
      }

      MoyenneADescendre = new Array
      for (i = 0; i < ListeJoursDate(data['DateDebutSprint'][0], data['DateFinSprint'][0]).length; i++) {
        MoyenneADescendre.push(Math.round(data['TotalHeuresAttribuees'][0] / NbJourDeTravail(data['DateDebutSprint'][0], data['DateFinSprint'][0])))
      }

      MoyenneDescendueTable = new Array
      for (j = 0; j < ListeJoursDate(data['DateDebutSprint'][0], data['DateFinSprint'][0]).length; j++) {
        MoyenneDescendueTable.push(Math.round(data['TotalHeuresDescendues'] / (FusionnerJoursEtHeures(data['DateDebutSprint'][0], data['DateFinSprint'][0], data['DateHeuresDescenduesParJour'], data['HeuresDescenduesParJour'])[1]).length))
      }

      new Highcharts.Chart({
        chart: {
          renderTo: div
        },
        title: {
          text: 'Heures descendues par jour <br>(toutes ressources comprises)'
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Heures'
          },

        },
        xAxis: {
          type: 'datetime',
          categories: AjouterJourFrDevantDate(ListeJoursDate(data['DateDebutSprint'][0], data['DateFinSprint'][0]))
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
            data: FusionnerJoursEtHeures(data['DateDebutSprint'][0], data['DateFinSprint'][0], data['DateHeuresDescenduesParJour'], data['HeuresDescenduesParJour'])[0],
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