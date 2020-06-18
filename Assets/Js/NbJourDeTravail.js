/**
 * Fonction pour fusionner une tableau de date avec un tableau d'heure et mettre null aux dates sans heures
 * @param {string} Debut a
 * @param {string} Fin b
 * @param {Array} JoursAvecHeures c
 * @param {Array} HeuresDesJours d
 */
function FusionnerJoursEtHeures(Debut, Fin, JoursAvecHeures, HeuresDesJours) {

  listeJoursDansSprint = ListeJoursDate(Debut, Fin)
  HeuresDescenduesParJoursSurToutLeSprint = new Array
  JoursOuvrableDejaPasse = new Array

  for (i = 0; i < listeJoursDansSprint.length; i++) {

    JourValide = 0

    for (y = 0; y < JoursAvecHeures.length; y++) {

      if (CustomYourDate(listeJoursDansSprint[i]) == CustomYourDate(JoursAvecHeures[y])) {

        var JourValide = 1
        HeuresDescenduesParJoursSurToutLeSprint.push(HeuresDesJours[y])
        JoursOuvrableDejaPasse.push(HeuresDesJours[y])

      }

    }

    if (JourValide == 0) {

      if (CustomYourDate(listeJoursDansSprint[i]) > new Date().toJSON().split('T')[0])
        HeuresDescenduesParJoursSurToutLeSprint.push(null)

      else if (new Date(CustomYourDate(listeJoursDansSprint[i])).getDay() == 6 || new Date(CustomYourDate(listeJoursDansSprint[i])).getDay() == 0)
        HeuresDescenduesParJoursSurToutLeSprint.push(0)

      else {
        HeuresDescenduesParJoursSurToutLeSprint.push(0)
        JoursOuvrableDejaPasse.push(0)

      }

    }

  }

  return [HeuresDescenduesParJoursSurToutLeSprint, JoursOuvrableDejaPasse];

}

/**
 * Fonction pour fusionner une tableau de date avec un tableau d'heure et mettre null aux dates sans heures
 * @param {string} Debut Date de debut du sprint
 * @param {string} Fin Date de fin
 * @param {Array} JoursAvecHeures Tableau de jours qui ont des heures descendues
 * @param {Array} HeuresDesJours Tableau des heures descendues par jours
 * @param {Int} PremiereValeur Nombre d'heures total a descendre pour avoir la premiere valeur
 */
function FusionnerJoursEtHeuresBurndDownChart(Debut, Fin, JoursAvecHeures, HeuresDesJours, PremiereValeur) {

  listeJoursDansSprint = ListeJoursDate(Debut, Fin)
  HeuresDescenduesParJoursSurToutLeSprint = new Array

  var HeureActuelle = PremiereValeur

  for (i = 0; i < listeJoursDansSprint.length; i++) {

    JourValide = 0

    for (y = 0; y < JoursAvecHeures.length; y++) {

      if (listeJoursDansSprint[i] == CustomYourDate(JoursAvecHeures[y])) {

        var JourValide = 1
        HeureActuelle = HeuresDesJours[y]
        HeuresDescenduesParJoursSurToutLeSprint.push(HeuresDesJours[y])

      }

    }

    if (JourValide == 0) {

      if (CustomYourDate(listeJoursDansSprint[i]) > new Date().toJSON().split('T')[0])
        HeuresDescenduesParJoursSurToutLeSprint.push(null)

      else {
        HeuresDescenduesParJoursSurToutLeSprint.push(HeureActuelle)
      }

    }

  }

  return HeuresDescenduesParJoursSurToutLeSprint;

}

/**
 * Convertie la date dans le format que l'on souhaite, C'EST TOI LE MAITRE
 * @param {string} date date a convertir
 * @param {string} LeFormat le format de concerstion
 */
function CustomYourDate(LaDate, LeFormat = "yyyy-mm-dd") {

  var jour, mois, annee

  if (LaDate == "" || LaDate == null || LaDate == undefined) {
    return ""
  }

  if ((/^[0-9]{4}/g).test(LaDate)) {
    var jour = LaDate.slice(8, 10)
    var mois = LaDate.slice(5, 7)
    var annee = LaDate.slice(0, 4)
  }

  else if ((/^[0-9]{2}/g).test(LaDate)) {
    var jour = LaDate.slice(0, 2)
    var mois = LaDate.slice(3, 5)
    var annee = LaDate.slice(6, 10)
  }

  switch (LeFormat) {
    case 'dd-mm-yyyy':
      return jour + '-' + mois + '-' + annee
    case 'dd/mm/yyyy':
      return jour + '/' + mois + '/' + annee
    case 'yyyy-mm-dd':
      return annee + '-' + mois + '-' + jour
    case 'yyyy/mm/dd':
      return annee + '/' + mois + '/' + jour
  }

}

/**
 * Retourn le tableau de date entré en paramettre avec son jour écrit devants chaque date exemple "Lun 05/10/18"
 * @param {Array} date Tableau de date
 */
function AjouterJourFrDevantDate(date) {

  retourDate = new Array();

  for (i = 0; i < date.length; i++) {

    dateConnuPourCheckDay = new Date(CustomYourDate(date[i]))

    switch (dateConnuPourCheckDay.getDay()) {
      case 1:
        retourDate.push("Lun " + CustomYourDate(date[i], 'dd/mm/yyyy'))
        break;
      case 2:
        retourDate.push("Mar " + CustomYourDate(date[i], 'dd/mm/yyyy'))
        break;
      case 3:
        retourDate.push("Mer " + CustomYourDate(date[i], 'dd/mm/yyyy'))
        break;
      case 4:
        retourDate.push("Jeu " + CustomYourDate(date[i], 'dd/mm/yyyy'))
        break;
      case 5:
        retourDate.push("Ven " + CustomYourDate(date[i], 'dd/mm/yyyy'))
        break;
      case 6:
        retourDate.push("Sam " + CustomYourDate(date[i], 'dd/mm/yyyy'))
        break;
      case 0:
        retourDate.push("Dim " + CustomYourDate(date[i], 'dd/mm/yyyy'))
        break;
      default:
        retourDate.push("NANI?" + CustomYourDate(date[i], 'dd/mm/yyyy'))
    }
  }

  return retourDate
}

/**
 * Permet de compter le nombre de jours de travail qui sont seulement "ouvré" entre deux dates données
 * @param {string} DateDebut Date de debut
 * @param {string} DateFin Date de fin
 */
function NbJourDeTravail(DateDebut, DateFin) {

  if (DateDebut.split('-')[0].length != 4)
    start = new Date(DateDebut.split('-')[2] + '-' + DateDebut.split('-')[1] + '-' + DateDebut.split('-')[0])
  else
    start = new Date(DateDebut)

  if (DateFin.split('-')[0].length != 4)
    end = new Date(DateFin.split('-')[2] + '-' + DateFin.split('-')[1] + '-' + DateFin.split('-')[0])
  else
    end = new Date(DateFin)

  var NbJoursDeTravailPossible = 0;

  if (start > end)
    return -1
  else {

    while (start <= end) {
      var day = start.getDay();

      if (day != 0 && day != 6) {
        NbJoursDeTravailPossible += 1
      }

      start.setDate(start.getDate() + 1);
    }
    return NbJoursDeTravailPossible;
  }

}

/**
 * Fonction pour obtenir la liste des jours entre deux date (extrémités comprisent)
 * @param {string} DateDebut Date de debut
 * @param {string} DateFin Date de fin
 */
function ListeJoursDate(DateDebut, DateFin) {

  start = new Date(CustomYourDate(DateDebut))

  end = new Date(CustomYourDate(DateFin))

  var EnsembleDeDate = new Array

  if (start > end)
    return -1
  else {
    while (start <= end) {
      var day = start.getDay();

      EnsembleDeDate.push(CustomYourDate(start.toJSON().split('T')[0]))

      start.setDate(start.getDate() + 1);
    }
    return EnsembleDeDate;
  }

}

/**
 * Fonction pour obtenir le nombre de jours entre deux date (extrémités comprisent)
 * @param {string} DateDebut Date de debut
 * @param {string} DateFin Date de fin
 */
function nbJoursEntreDeuxDates(dateDebut) {
  const date1 = new Date(dateDebut);
  const date2 = new Date();
  const diffTime = Math.abs(date2 - date1);
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  return diffDays - 1
}