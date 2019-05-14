function IsJsonString(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}

/**
 * @param {number} NumeroduSprint - Numéro du sprint
 * @param {string} affichage - Si affichage = 0, afficher ressources, sinon afficher projet
 * @param {string} div - Nom du div qui va prendre la chart
 */
function GetTotalHeuresAttribueDescendueProjetEmploye(NumeroduSprint, affichage, div) {
  console.log("Id sprint : ", NumeroduSprint + " | Afficher projet: ", affichage);
  console.log();

  $.ajax({
    url: "Modele/Accueil.php",
    method: "POST",
    data: {
      action: "GetTotalHeuresDescenduesParEmploye",
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {
      if (IsJsonString(data)) 
        data = JSON.parse(data);
      
      if (affichage == "Ressources") {
        Highcharts.chart(div, {
          chart: {
            type: "column"
          },
          title: {
            text: "Total heures attribuées / descendues (triées par ressources)"
          },
          xAxis: {
            type: "category",
            categories: data["NomRessource"],
            labels: {
              rotation: -45,
              style: {
                fontSize: "15px",
                fontFamily: "Verdana, sans-serif"
              }
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: "Heures"
            }
          },
          tooltip: {
            shared: true
          },
          plotOptions: {
            column: {
              stacking: "normal",
              grouping: false,
              shadow: true,
              borderWidth: 1
            },
            dataLabels: {
              enabled: true,
              format: ""
            }
          },
          series: [
            {
              name: "Heures attribuées",
              data: data["RessourceHeureAttribuees"],
              stack: 0,
              pointPadding: 0.3
            }, {
              name: "Heures Interférences",
              data: data["RessourceHeureInterference"],
              stack: 1,
              color: "#ca2ff9",
              pointPadding: 0.4
            }, {
              name: "Heures descendues",
              data: data["RessourceHeuresDescendues"],
              stack: 1,
              pointPadding: 0.4
            }
          ]
        });
      } else {
        Highcharts.chart(div, {
          chart: {
            type: "column"
          },
          title: {
            text: "Total heures attribuées / descendues (triées par projet)"
          },
          xAxis: {
            type: "category",
            categories: data["NomProjet"],
            labels: {
              rotation: -45,
              style: {
                fontSize: "15px",
                fontFamily: "Verdana, sans-serif"
              }
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: "Heures"
            }
          },
          tooltip: {
            shared: true
          },
          plotOptions: {
            column: {
              stacking: "normal",
              grouping: false,
              shadow: true,
              borderWidth: 1
            }
          },
          series: [
            {
              name: "Heures attribuées",
              data: data["ProjetHeuresAttribuees"],
              stack: 0,
              pointPadding: 0.3
            }, {
              name: "Heures interference",
              data: data["ProjetHeuresInterferences"],
              stack: 1,
              color: "#ca2ff9",
              pointPadding: 0.4
            }, {
              name: "Heures descendues",
              data: data["ProjetHeuresDescendues"],
              stack: 1,
              pointPadding: 0.4
            }
          ]
        });
      }
    }
  });
}

function GetTotalHeuresAttribueDescendue(NumeroduSprint, div) {
  $.ajax({
    url: "Modele/Accueil.php",
    method: "POST",
    data: {
      action: "GetTotalHeuresDescenduesParEmploye",
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {
      if (IsJsonString(data)) 
        data = JSON.parse(data);
      
      Highcharts.chart(div, {
        chart: {
          type: "column"
        },
        title: {
          text: "Total heures attribuées/descendues<br>(toutes ressources comprises)"
        },
        yAxis: {
          title: {
            text: "Heures"
          }
        },
        tooltip: {
          shared: true
        },
        plotOptions: {
          column: {
            stacking: "normal",
            grouping: false
          },
          dataLabels: {
            enabled: true
          }
        },
        series: [
          {
            name: "Heures attribuées",
            data: data["TotalHeuresAttribuees"],
            stack: 0,
            pointPadding: 0.3
          }, {
            name: "Heures interférence",
            color: "#ca2ff9",
            data: data["TotalHeuresInterference"],
            stack: 1,
            pointPadding: 0.4
          }, {
            name: "Heures descendues",
            data: data["TotalHeuresDescendues"],
            stack: 1,
            pointPadding: 0.4
          }
        ]
      });
    }
  });
}

function ChargerPieObjectif(NumeroduSprint, div) {
  $.ajax({
    url: "Modele/Accueil.php",
    method: "POST",
    data: {
      action: "GetTotalHeuresDescenduesParEmploye",
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {
      if (IsJsonString(data)) 
        data = JSON.parse(data);
      
      var finalColors = data["Objectifs"].map(o => o[2]);
      Highcharts.chart(div, {
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: "pie"
        },
        colors: finalColors,
        title: {
          text: "Etat des objectifs de la rétrospective"
        },
        tooltip: {
          pointFormat: "<b>{point.percentage:.1f}%</b>"
        },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: "pointer",
            dataLabels: {
              enabled: true,
              format: "{point.name} ({point.y})"
            }
          }
        },
        series: [
          {
            name: " ",
            data: data["Objectifs"]
          }
        ]
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

  var tableauSeuil = new Array();
  for (i = 0; i < jours.length; i++) {
    tableauSeuil.push(seuils);
  }

  new Highcharts.Chart({
    chart: {
      type: "area",
      renderTo: div
    },
    title: {
      text: "BurnDown Chart"
    },
    yAxis: {
      min: 0,
      title: {
        text: "Heures"
      }
    },
    xAxis: {
      type: "datetime",
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
    series: [
      {
        name: "Heures Restantes",
        data: heures
      }, {
        name: "Seuil (interférence, congé, ...)",
        data: tableauSeuil,
        color: "#ca2ff9"
      }
    ]
  });
}

/**
 * Fonction pour remplir les textes a coté de la burbndown chart
 * @param {Array} infosource - Tableau avec toutes les valeurs de la burndown chart
 */
function fillInformation(infosource) {
  $("#TotADescendre").text(infosource["TotalHeuresAttribuees"][0] - infosource["TotalHeuresDescendues"][0]/* - infosource['TotalHeuresInterference'][0] */);

  var moyenne = Math.round((infosource["TotalHeuresDescendues"][0] + infosource["TotalHeuresInterference"][0]) / infosource["TotalHeuresAttribuees"][0] * 100);

  if (moyenne < 50) 
    var couleurBar = "danger";
  else if (moyenne >= 50 && moyenne < 75) 
    var couleurBar = "warning";
  else 
    var couleurBar = "success";
  
  $("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-' + couleurBar + '" role="progressbar" style="width: ' + moyenne + '%; aria-valuenow="' + moyenne + '" aria-valuemin="0" aria-valuemax="100"></div></div>');

  $("#PourcentageDescendue").text(Math.round(moyenne) + "%");
}

/**
 * Création / mettre a jours les infos de la burndownchart
 * @param {number} NumeroSprint - Int numéro du sprint en cours
 * @param {string} div - String div dans lequel mettre la burndownchart
 */
function UpdateBurndownchart(NumeroSprint, div) {
  $.ajax({
    url: "Modele/Accueil.php",
    method: "POST",
    data: {
      action: "GetTotalHeuresDescenduesParEmploye",
      NumeroduSprint: NumeroSprint
    },
    success: function (Total) {
      if (IsJsonString(Total)) 
        Total = JSON.parse(Total);
      
      fillInformation(Total);

      console.log("Liste d'infos", Total);

      CreerLaBurnDownChart(FusionnerJoursEtHeuresBurndDownChart(Total["DateDebutSprint"], Total["DateFinSprint"], Total["DateHeuresDescenduesParJour"], Total["BurndownchartHeuresTable"], Total["TotalHeuresAttribuees"][0]), Total["TotalHeuresInterference"][0], div, AjouterJourFrDevantDate(ListeJoursDate(Total["DateDebutSprint"], Total["DateFinSprint"])));
    }
  });
}

/**
 * Permet d'afficher la chart avec les heures descendues par jour par les ressources, la moyenne de combien il aurait fallu descendre et combien en moyenne ils ont descendu
 * @param {number} NumeroduSprint
 * @param {string} div
 */
function HeuresDescenduesParJours(NumeroduSprint, div) {
  $.ajax({
    url: "Modele/Accueil.php",
    method: "POST",
    data: {
      action: "GetTotalHeuresDescenduesParEmploye",
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {
      if (IsJsonString(data)) 
        data = JSON.parse(data);
      
      MoyenneADescendre = new Array();
      for (i = 0; i < ListeJoursDate(data["DateDebutSprint"], data["DateFinSprint"]).length; i++) {
        MoyenneADescendre.push(Math.round(data["TotalHeuresAttribuees"][0] / NbJourDeTravail(data["DateDebutSprint"], data["DateFinSprint"])));
      }

      MoyenneDescendueTable = new Array();
      for (j = 0; j < ListeJoursDate(data["DateDebutSprint"], data["DateFinSprint"]).length; j++) {
        MoyenneDescendueTable.push(Math.round(data["TotalHeuresDescendues"] / FusionnerJoursEtHeures(data["DateDebutSprint"], data["DateFinSprint"], data["DateHeuresDescenduesParJour"], data["HeuresDescenduesParJour"])[1].length));
      }

      new Highcharts.Chart({
        chart: {
          renderTo: div
        },
        title: {
          text: "Heures descendues par jour <br>(toutes ressources comprises)"
        },
        yAxis: {
          min: 0,
          title: {
            text: "Heures"
          }
        },
        xAxis: {
          type: "datetime",
          categories: AjouterJourFrDevantDate(ListeJoursDate(data["DateDebutSprint"], data["DateFinSprint"]))
        },
        plotOptions: {
          line: {
            dataLabels: {
              enabled: true
            },
            enableMouseTracking: true
          }
        },
        series: [
          {
            name: "Moyenne d'heures descendues",
            data: MoyenneDescendueTable,
            color: "#c1c1c1",
            marker: false,
            enableMouseTracking: false,
            dataLabels: {
              enabled: false
            }
          }, {
            name: "Moyenne d'heures a descendre",
            data: MoyenneADescendre,
            color: "#4f4f4f",
            marker: false,
            enableMouseTracking: false,
            dataLabels: {
              enabled: false
            }
          }, {
            name: "Heures descendues par jour",
            data: FusionnerJoursEtHeures(data["DateDebutSprint"], data["DateFinSprint"], data["DateHeuresDescenduesParJour"], data["HeuresDescenduesParJour"])[0],
            zones: [
              {
                value: MoyenneADescendre[0],
                color: "#ff4747"
              }, {
                color: "#00c652"
              }
            ]
          }
        ]
      });
    }
  });
}