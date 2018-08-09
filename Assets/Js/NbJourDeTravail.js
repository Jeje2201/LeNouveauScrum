/**
 * Fonction pour fusionner une tableau de date avec un tableau d'heure et mettre null aux dates sans heures
 * @param {string} Debut a
 * @param {string} Fin b
 * @param {Array} JoursAvecHeures c
 * @param {Array} HeuresDesJours d
 */
function FusionnerJoursEtHeures(Debut, Fin, JoursAvecHeures, HeuresDesJours) {

  listeJoursDansSprint = ListeJoursDate(Debut, Fin)
  // console.log('tous les jours entre debyt et fin: ' + listeJoursDansSprint)
  HeuresDescenduesParJoursSurToutLeSprint = new Array
  JoursOuvrableDejaPasse = new Array

  for (i = 0; i < listeJoursDansSprint.length; i++) {

    JourValide = 0

    for (y = 0; y < JoursAvecHeures.length; y++) {

      if (listeJoursDansSprint[i] == JoursAvecHeures[y]) {

        var JourValide = 1
        HeuresDescenduesParJoursSurToutLeSprint.push(HeuresDesJours[y])
        JoursOuvrableDejaPasse.push(HeuresDesJours[y])

      }

    }

    if (JourValide == 0) {

      if (DateFrToEn(listeJoursDansSprint[i]) > new Date().toJSON().split('T')[0])
        HeuresDescenduesParJoursSurToutLeSprint.push(null)

      else if (new Date(DateFrToEn(listeJoursDansSprint[i])).getDay() == 6 || new Date(DateFrToEn(listeJoursDansSprint[i])).getDay() == 0)
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
* @param {string} Debut a
* @param {string} Fin b
* @param {Array} JoursAvecHeures c
* @param {Array} HeuresDesJours d
*/
function FusionnerJoursEtHeuresBurndDownChart(Debut, Fin, JoursAvecHeures, HeuresDesJours, PremiereValeur) {

  // console.log('total a descendre pour bd:' + PremiereValeur)

  listeJoursDansSprint = ListeJoursDate(Debut, Fin)
  // console.log('tous les jours entre debyt et fin: ' + listeJoursDansSprint)
  HeuresDescenduesParJoursSurToutLeSprint = new Array

  var HeureActuelle = PremiereValeur
  // console.log('Heure restantes: '+HeureActuelle)

  for (i = 0; i < listeJoursDansSprint.length; i++) {

    JourValide = 0

    for (y = 0; y < JoursAvecHeures.length; y++) {

      if (listeJoursDansSprint[i] == JoursAvecHeures[y]) {

        // console.log('match entre deux dates: '+ listeJoursDansSprint[i] + ' = ' + JoursAvecHeures[y])

        var JourValide = 1
        HeureActuelle = HeuresDesJours[y]
        HeuresDescenduesParJoursSurToutLeSprint.push(HeuresDesJours[y])

      }

    }

    if (JourValide == 0) {

      if (DateFrToEn(listeJoursDansSprint[i]) > new Date().toJSON().split('T')[0])
        HeuresDescenduesParJoursSurToutLeSprint.push(null)

      else {
        HeuresDescenduesParJoursSurToutLeSprint.push(HeureActuelle)
      }

    }

  }

  return HeuresDescenduesParJoursSurToutLeSprint;

}

function ChoixDate(jours) {

  if (jours == null) {
    var jours = 14;
  }
  else {
    jours = parseInt(jours);
  }

  var Apres = new Date();
  Apres.setDate(Apres.getDate() + jours);
  j = Apres.getDate(),
    m = Apres.getMonth() + 1,
    a = Apres.getFullYear();

  if (j < 10) {
    j = "0" + j;
  };
  if (m < 10) {
    m = "0" + m;
  };

  return j + "-" + m + "-" + a;

};

function DateFrToEn(date) {

  date = date.split("-")
  NouvelleDate = date[2] + "-" + date[1] + "-" + date[0]

  return NouvelleDate;

};

function AjouterJourFrDevantDate(date) {

  retourDate = new Array();

  for (i = 0; i < date.length; i++) {

    dateconnupourcheckday = new Date(DateFrToEn(date[i]))

    switch (dateconnupourcheckday.getDay()) {
      case 1:
        retourDate.push("Lun " + date[i])
        break;
      case 2:
        retourDate.push("Mar " + date[i])
        break;
      case 3:
        retourDate.push("Mer " + date[i])
        break;
      case 4:
        retourDate.push("Jeu " + date[i])
        break;
      case 5:
        retourDate.push("Ven " + date[i])
        break;
      case 6:
        retourDate.push("Sam " + date[i])
        break;
      case 0:
        retourDate.push("Dim " + date[i])
        break;
      default:
        retourDate.push("NANI?" + date[i])
    }
  }

  return retourDate
}

function JoursFeries() {

  var an = new Date().toJSON().split('T')[0].split('-')[0];

  var JourAn = new Date(an, "00", "01")
  var FeteTravail = new Date(an, "04", "01")
  var Victoire1945 = new Date(an, "04", "08")
  var FeteNationale = new Date(an, "06", "14")
  var Assomption = new Date(an, "07", "15")
  var Toussaint = new Date(an, "10", "01")
  var Armistice = new Date(an, "10", "11")
  var Noel = new Date(an, "11", "25")

  var G = an % 19
  var C = Math.floor(an / 100)
  var H = (C - Math.floor(C / 4) - Math.floor((8 * C + 13) / 25) + 19 * G + 15) % 30
  var I = H - Math.floor(H / 28) * (1 - Math.floor(H / 28) * Math.floor(29 / (H + 1)) * Math.floor((21 - G) / 11))
  var J = (an * 1 + Math.floor(an / 4) + I + 2 - C + Math.floor(C / 4)) % 7
  var L = I - J
  var MoisPaques = 3 + Math.floor((L + 40) / 44)
  var JourPaques = L + 28 - 31 * Math.floor(MoisPaques / 4)
  var LundiPaques = new Date(an, MoisPaques - 1, JourPaques + 1)
  var Ascension = new Date(an, MoisPaques - 1, JourPaques + 39)
  var LundiPentecote = new Date(an, MoisPaques - 1, JourPaques + 50)

  return new Array(JourAn, LundiPaques, FeteTravail, Victoire1945, Ascension, LundiPentecote, FeteNationale, Assomption, Toussaint, Armistice, Noel)
}

function NbJourDeTravail(DateDebut, DateFin) {


  if (DateDebut.split('-')[0].length != 4)
    start = new Date(DateDebut.split('-')[2] + '-' + DateDebut.split('-')[1] + '-' + DateDebut.split('-')[0])
  else
    start = new Date(DateDebut)

  if (DateFin.split('-')[0].length != 4)
    end = new Date(DateFin.split('-')[2] + '-' + DateFin.split('-')[1] + '-' + DateFin.split('-')[0])
  else
    end = new Date(DateFin)

  var NbHeureAttribuableMax = 0;

  if (start > end)
    return -1
  else {

    // alert('nb jours fériés: '+ JoursFeries().length)

    while (start <= end) {
      var day = start.getDay();

      if (day != 0 && day != 6) {
        NbHeureAttribuableMax += 1
      }

      // alert('Un jours dans le groupe de jours'+start)
      console.log('!! ' + start + ' !!')

      for (j = 0; j < JoursFeries().length; j++) {

        if (start.toJSON().split('T')[0] == JoursFeries()[j].toJSON().split('T')[0])
          NbHeureAttribuableMax -= 1

      }

      start.setDate(start.getDate() + 1);
    }
    return NbHeureAttribuableMax;
  }

}

function ListeJoursDate(DateDebut, DateFin) {

  if (DateDebut.split('-')[0].length != 4)
    start = new Date(DateDebut.split('-')[2] + '-' + DateDebut.split('-')[1] + '-' + DateDebut.split('-')[0])
  else
    start = new Date(DateDebut)

  if (DateFin.split('-')[0].length != 4)
    end = new Date(DateFin.split('-')[2] + '-' + DateFin.split('-')[1] + '-' + DateFin.split('-')[0])
  else
    end = new Date(DateFin)

  var EnsembleDeDate = new Array

  if (start > end)
    return -1
  else {
    while (start <= end) {
      var day = start.getDay();

      EnsembleDeDate.push(DateFrToEn(start.toJSON().split('T')[0]))

      start.setDate(start.getDate() + 1);
    }
    return EnsembleDeDate;
  }

}