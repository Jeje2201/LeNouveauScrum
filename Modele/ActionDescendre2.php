   <?php

require_once ('../Modele/Configs.php');

  if(isset($_POST["action"])) 
  {

   if($_POST["action"] == "AfficherCards") 
   {
    $Test = new stdClass;

    $idEmploye = $_POST["idEmploye"];
    $numero = $_POST["idAffiche"];

    if($_POST["idEmploye"] == "ToutLeMonde")
      $Requete1 = "AND attribution.id_Employe in (select id from employe)";
    else
      $Requete1 = "AND attribution.id_Employe = $idEmploye";

    $statement = $connection->prepare("
      SELECT attribution.id, attribution.heure as NbHeure, projet.nom as projet, projet.Logo as Logo, employe.Initial as E_Initial, employe.couleur as E_Couleur, employe.prenom as E_Prenom, employe.nom as E_Nom, employe.Pseudo as E_Pseudo
      FROM attribution
      inner JOIN employe ON employe.id = attribution.id_Employe
      INNER JOIN projet ON projet.id = attribution.id_Projet
      INNER JOIN sprint ON sprint.id = attribution.id_Sprint
      where attribution.id_Sprint = $numero "
      .$Requete1.
      " AND attribution.id not in
      (SELECT distinct heuresdescendues.id_Attribution
      from heuresdescendues
      where heuresdescendues.id_Attribution IS NOT NULL)
      ORDER BY employe.prenom
      ");

    $statement->execute();
    $result = $statement->fetchAll();
    $output1 = '';
    if($statement->rowCount() > 0)
    {
     foreach($result as $row)
     {
      $output1.='
      <div class="card BOUGEMOI" id="'.$row["id"].'" onclick="DeplaceToi(this)">
        <img class="LogoProjet" src="Assets/Image/Projets/'.$row["Logo"].'">
        <div style="margin-left:7px;">
          <div class="BarreLateralCard" style="background-color:'.$row["E_Couleur"].';"></div>
          <span title="'.$row["E_Prenom"].' '.$row["E_Nom"].'">
            <i class="fa fa-user-o" aria-hidden="true"></i> '.$row["E_Pseudo"].' ('.$row["E_Initial"].')<br>
            <div class="SpecialHr"></div>
            <i class="fa fa-tag" aria-hidden="true"></i> '.$row["projet"].'<br>
            <div class="SpecialHr"></div>
            <i class="fa fa-clock-o" aria-hidden="true"></i> '.$row["NbHeure"].'(h)
          </span>
        </div>
      </div>';
    }
  }
  else{
    $output1 .='Aucune tâche en cours';
  }

  if($_POST["idEmploye"] == "ToutLeMonde")
   $Requete2 = "AND id_Employe in (select id from employe)";
 else
  $Requete2 = "AND id_Employe = $idEmploye";

$statement = $connection->prepare("
  SELECT heuresdescendues.id as id, heuresdescendues.heure as NbHeure, heuresdescendues.DateDescendu as Datee, projet.nom as projet, projet.Logo as Logo, employe.Initial as E_Initial, employe.couleur as E_Couleur, employe.nom as E_Nom, employe.prenom as E_Prenom, employe.Pseudo as E_Pseudo
  FROM heuresdescendues
  INNER JOIN employe ON heuresdescendues.id_Employe = employe.id
  INNER JOIN projet on projet.id = heuresdescendues.id_Projet
  INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint
  WHERE id_sprint= $numero "
  .$Requete2.
  " ORDER BY employe.prenom");

$statement->execute();
$result = $statement->fetchAll();
$output2 = '';
if($statement->rowCount() > 0)
{
 foreach($result as $row)
 {

  $output2.='
<div class="card PASTOUCHE">
  <img class="LogoProjet" src="Assets/Image/Projets/'.$row["Logo"].'">
  <div style="margin-left:7px;">
    <div class="BarreLateralCard" style="background-color:'.$row["E_Couleur"].';"></div>
    <span title="'.$row["E_Prenom"].' '.$row["E_Nom"].'">
      <i class="fa fa-user-o" aria-hidden="true"></i> '.$row["E_Pseudo"].' ('.$row["E_Initial"].')<br>
      <div class="SpecialHr"></div>
      <i class="fa fa-tag" aria-hidden="true"></i> '.$row["projet"].'<br>
      <div class="SpecialHr"></div>
      <i class="fa fa-clock-o" aria-hidden="true"></i> '.$row["NbHeure"].'(h)
    </span>
  </div>
</div>';

}
}
  else{
    $output2 .='Aucune tâche achevé';
  }
$Test -> Attribution = $output1;
$Test -> Descendue = $output2;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($Test);

}

   if($_POST["action"] == "LoadListEmployes") 
   {
    $Test = new stdClass;

    $numero = $_POST["idAffiche"];

$statement = $connection->prepare("
  SELECT DISTINCT (select employe.prenom from employe where employe.id = attribution.id_Employe) as Prenom, (select employe.nom from employe where employe.id = attribution.id_Employe) as Nom, attribution.id_Employe as id
  FROM attribution
  where attribution.id_Sprint = $numero
  order by (select employe.prenom from employe where employe.id = attribution.id_Employe)
  ");

$statement->execute();
$result = $statement->fetchAll();
$output2 = '<select class="form-control"  id="numeroEmploye" name="numeroEmploye">
              <option value="ToutLeMonde">*</option>';
if($statement->rowCount() > 0)
{
 foreach($result as $row)
 {

$output2.='<option value="'.$row["id"].'"> '.$row["Prenom"].' '.$row["Nom"].' </option>';

}

$output2 .= '</select>';
}
$Test -> Attribution = $output2;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($Test);

}

if($_POST["action"] == "DateMinMax")
{

  $idAffiche = $_POST["idAffiche"];

  $statement = $connection->prepare(
   $sql = "SELECT `dateDebut` as DateMin, `dateFin` as DateMax from sprint where sprint.id = $idAffiche"
 );
  $statement->execute();
  $result = $statement->fetchAll();

  $DateMin = [];
  $DateMax = [];

  foreach ($result as $row) {
   $DateMin[] = $row['DateMin'];
   $DateMax[] = $row['DateMax'];
 }

 $array[] = $DateMin;
 $array[] = $DateMax;

 header('Cache-Control: no-cache, must-revalidate');
 header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
 header('Content-type: application/json');
 echo json_encode($array);

}

if($_POST["action"] == "Descendre")
{

  $LeJourDeDescente = $_POST["LeJourDeDescente"];
  $IdAttribue = $_POST["IdAttribue"];

  for($i=0;$i < sizeof($IdAttribue) ;$i++){

    $statement = $connection->prepare("
      INSERT INTO heuresdescendues (heure, id_Sprint, id_Employe, id_Projet, id_Attribution, DateDescendu)
      SELECT heure, id_Sprint, id_Employe, id_Projet, id, '$LeJourDeDescente' FROM attribution where attribution.id = $IdAttribue[$i];
      ");
    $result = $statement->execute();
  }
  if(!empty($result))
  {
   echo 'Tâche(s) attribuée(s) bien descendue(s) 😄';
 }
 else
 {
  echo 'Probleme';
}
}

if($_POST["action"] == "Select")
{
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM heuresdescendues 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
 );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["heure"] = $row["heure"];
   $output["DateAujourdhui"] = $row["DateDescendu"];
   $output["id_Employe"] = $row["id_Employe"];
   $output["id_Projet"] = $row["id_Projet"];
 }
 echo json_encode($output);
}

if($_POST["action"] == "Update")
{
  $statement = $connection->prepare(
   "UPDATE heuresdescendues
   SET heure = :heure, id_Sprint = :id_Sprint, id_Projet = :id_Projet, DateDescendu = :DateDescendu, id_Employe = :id_Employe 
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':heure' => $_POST["NombreHeure"],
    ':DateDescendu' => $_POST["DateAujourdhui"],
    ':id_Sprint' => $_POST["idSprint"],
    ':id_Projet' => $_POST["idProjet"],
    ':id_Employe'   => $_POST["idEmploye"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Heure(s) descendue(s) modifiée(s) ! 😮';
 }
}

if($_POST["action"] == "Delete")
{
  $statement = $connection->prepare(
   "DELETE FROM heuresdescendues WHERE id = :id"
 );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Heure(s) descendue(s) supprimée(s) ! 😢';
 }
}

}

?>
