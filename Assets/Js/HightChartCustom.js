/**
 * @param {number} NumeroduSprint - Numéro du sprint
 * @param {string} affichage - Si affichage = 0, afficher ressources, sinon afficher projet
 * @param {string} div - Nom du div qui va prendre la chart
 */
function GetTotalHeuresAttribueDescendueProjetEmploye(NumeroduSprint, affichage, div) {

  $.ajax({
    url: "Modele/Accueil.php",
    method: "POST",
    dataType: "json",
    data: {
      action: "GetTotalHeuresDescenduesParEmploye",
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {
      
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
      text: "Burndown chart"
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
      series: {
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
 * Création / mettre a jours les infos de la burndownchart
 * @param {number} NumeroSprint - Int numéro du sprint en cours
 * @param {string} div - String div dans lequel mettre la burndownchart
 */
function UpdateBurndownchart(NumeroSprint, div) {
  $.ajax({
    url: "Modele/Accueil.php",
    method: "POST",
    dataType: "json",
    data: {
      action: "GetTotalHeuresDescenduesParEmploye",
      NumeroduSprint: NumeroSprint
    },
    success: function (Total) {

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
    dataType: "json",
    data: {
      action: "GetTotalHeuresDescenduesParEmploye",
      NumeroduSprint: NumeroduSprint
    },
    success: function (data) {
      
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