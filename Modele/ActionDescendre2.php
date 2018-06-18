   <?php

   $username = 'root';
   $password = '';
   $connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); 

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $Test = new stdClass;

      $idEmploye = $_POST["idEmploye"];
      $numero = $_POST["idAffiche"];

      if($_POST["idEmploye"] == "DAMSON"){
       $statement = $connection->prepare("
        SELECT attribution.id, attribution.heure as NbHeure, projet.nom as projet, projet.cheminIcone as Logo, employe.Initial as E_Initial, employe.couleur as E_Couleur, employe.prenom as E_Prenom
        FROM attribution
        inner JOIN employe ON employe.id = attribution.id_Employe
        INNER JOIN projet ON projet.id = attribution.id_Projet
        INNER JOIN sprint ON sprint.id = attribution.id_Sprint
        where attribution.id_Sprint = $numero
        AND attribution.id_Employe in (select id from employe)
        AND attribution.id not in
        (SELECT distinct heuresdescendues.id_Attribution
        from heuresdescendues
        where heuresdescendues.id_Attribution IS NOT NULL)
        ORDER BY employe.prenom
        ");
     }

     else{

      $statement = $connection->prepare("
        SELECT attribution.id, attribution.heure as NbHeure, projet.nom as projet, projet.cheminIcone as Logo, employe.Initial as E_Initial, employe.couleur as E_Couleur, employe.prenom as E_Prenom
        FROM attribution
        inner JOIN employe ON employe.id = attribution.id_Employe
        INNER JOIN projet ON projet.id = attribution.id_Projet
        INNER JOIN sprint ON sprint.id = attribution.id_Sprint
        where attribution.id_Sprint = $numero
        AND attribution.id_Employe = $idEmploye
        AND attribution.id not in
        (SELECT distinct heuresdescendues.id_Attribution
        from heuresdescendues
        where heuresdescendues.id_Attribution IS NOT NULL)
        ORDER BY employe.prenom
        ");
    }
    $statement->execute();
    $result = $statement->fetchAll();
    $output1 = '';
    if($statement->rowCount() > 0)
    {
     foreach($result as $row)
     {

      $output1.='<div class="card" style="background-color:'.$row["E_Couleur"].'">
      <div class="card-body text-center">
      <div class="card-body-icon">
                <img src="'.$row["Logo"].'" width="40px">
              </div>
      <p class="card-text"><b>'.$row["E_Prenom"].' ('.$row["E_Initial"].')</b><br><u>'.$row["projet"].'</u><br><i>'.$row["NbHeure"].'h</i></p>
      <input style="display: none" id="lavaleur1" value="'.$row["id"].'" />
      <a style="display: none" class="btn btn-primary btn-block" href="#" onclick="GoTop(this)"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
      <a class="btn btn-primary btn-block" href="#" onclick="GoDown(this)"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
      </div>
      </div>';

    }
  }
  else{
    $output1.='<div class="card bg-light">
    <div class="card-body text-center">
    <p class="card-text">Toutes les tâches sont terminées! 😎</p>
    </div>
    </div>';
  }

  $Test -> Attribution = $output1;
  if($_POST["idEmploye"] == "DAMSON"){

    $statement = $connection->prepare("
      SELECT heuresdescendues.id as id, heuresdescendues.heure as NbHeure, heuresdescendues.DateDescendu as Datee, projet.nom as projet, projet.cheminIcone as Logo, employe.Initial as E_Initial, employe.couleur as E_Couleur, employe.prenom as E_Prenom
      FROM heuresdescendues
      INNER JOIN employe ON heuresdescendues.id_Employe = employe.id
      INNER JOIN projet on projet.id = heuresdescendues.id_Projet
      INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint
      WHERE id_sprint= $numero
      AND id_Employe in (select id from employe)
      ORDER BY employe.prenom");
  }
  else{
    $statement = $connection->prepare("SELECT heuresdescendues.id as id, heuresdescendues.heure as NbHeure, heuresdescendues.DateDescendu as Datee, projet.nom as projet, projet.cheminIcone as Logo, employe.Initial as E_Initial, employe.prenom as E_Prenom, employe.couleur as E_Couleur
      FROM heuresdescendues
      INNER JOIN employe ON heuresdescendues.id_Employe = employe.id
      INNER JOIN projet on projet.id = heuresdescendues.id_Projet
      INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint
      WHERE id_sprint= $numero
      AND id_Employe = $idEmploye
      ORDER BY employe.prenom");

  }

  $statement->execute();
  $result = $statement->fetchAll();
  $output2 = '';
  if($statement->rowCount() > 0)
  {
   foreach($result as $row)
   {

    $output2.='<div class="card" style="background-color:'.$row["E_Couleur"].'">
    <div class="card-body text-center">
      <div class="card-body-icon">
                <img src="'.$row["Logo"].'" width="40px">
              </div>
    <p class="card-text"><b>'.$row["E_Prenom"].' ('.$row["E_Initial"].')</b><br><u>'.$row["projet"].'</u><br><i>'.$row["NbHeure"].'h</i></p>
    </div>
    </div>';

  }
}
$Test -> Descendue = $output2;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($Test);

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

    if(!empty($result))
    {
     echo 'Tâche(s) attribuée(s) bien descendue(s)';
   }
   else
   {
    echo 'Probleme';
  }
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
