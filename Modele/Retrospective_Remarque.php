<?php
session_start();
require_once('../Modele/Configs.php');

if (isset($_POST["action"])) {

  if ($_POST["action"] == "getRemarques") {
    $statement = $connection->prepare("SELECT
        R.id as remarque_id,
        R.Label as remarque_label,
        R.DateCreation as remarque_dateCreation,
        R.DateFini as remarque_dateFini
        FROM retrospective_remarque R
        ORDER BY R.DateFini IS NULL ASC, R.DateFini ASC");

    $statement->execute();
    $result = $statement->fetchAll();

    $resultat = [];

    foreach ($result as $row) {

      $MonTest = [];

      $MonTest['remarque_id'] = $row['remarque_id'];
      $MonTest['remarque_label'] = $row['remarque_label'];

      if ($row["remarque_dateCreation"] == null)
        $MonTest["remarque_dateCreation"] = "";
      else
        $MonTest["remarque_dateCreation"] = date("d/m/Y", strtotime($row["remarque_dateCreation"]));

      if ($row["remarque_dateFini"] == null)
        $MonTest["remarque_dateFini"] = "";
      else
        $MonTest["remarque_dateFini"] = date("d/m/Y", strtotime($row["remarque_dateFini"]));

      $resultat[] = $MonTest;
    }

    print json_encode($resultat);
  }

  if ($_POST["action"] == "getRemarque") {

    $statement = $connection->prepare(
      "SELECT * FROM retrospective_remarque 
     WHERE id = '" . $_POST["remarque_id"] . "' 
     LIMIT 1"
    );
    $statement->execute();
    $result = $statement->fetch();

    $resultat = [];

    $resultat["RetrospectiveRemarque_DateCreation"] = date("d-m-Y", strtotime($result["DateCreation"]));

    if ($result["DateFini"] == null)
      $resultat["RetrospectiveRemarque_DateFini"] = "";
    else
      $resultat["RetrospectiveRemarque_DateFini"] = date("d-m-Y", strtotime($result["DateFini"]));

    $resultat["RetrospectiveRemarque_Label"] = $result["Label"];
    $resultat["RetrospectiveRemarque_id"] = $result["id"];

    print json_encode($resultat);
  }

  if ($_POST["action"] == "achieveRetrospective") {
    $statement = $connection->prepare(
      "UPDATE retrospective_remarque 
      SET DateFini = NOW()
      WHERE id = :id
      "
    );
    $result = $statement->execute(
      array(
        ':id' => $_POST["remarque_id"]
      )
    );
    if (!empty($result))
      print true;
    else
      print_r($statement->errorInfo());
  }

  if ($_POST["action"] == "addRemarque") {
    $statement = $connection->prepare("
   INSERT INTO retrospective_remarque (Label, DateCreation) 
   VALUES (:Label, NOW())
   ");
    $result = $statement->execute(
      array(
        ':Label' => $_POST["Labelretrospective"]
      )
    );
    if (!empty($result))
      print true;
    else
      print_r($statement->errorInfo());
  }

  if ($_POST["action"] == "putRemarque") {

    if ($_POST["remarque_DateFin"] == "")
      $_POST["remarque_DateFin"] = null;
      
    $statement = $connection->prepare(
      "UPDATE retrospective_remarque
      SET Label = :remarque_label, DateCreation = :remarque_DateDebut, DateFini = :remarque_DateFin
      WHERE id = :remarque_id"
    );
    $result = $statement->execute(
      array(
        ':remarque_label' => $_POST["remarque_label"],
        ':remarque_DateDebut' => $_POST["remarque_DateDebut"],
        ':remarque_DateFin' => $_POST["remarque_DateFin"],
        ':remarque_id' => $_POST["remarque_id"]
      )
    );
    if (!empty($result))
      print true;
    else
      print_r($statement->errorInfo());
  }

  if ($_POST["action"] == "dellRemarque") {
    $statement = $connection->prepare(
      "DELETE FROM retrospective_remarque
         WHERE id = :id"
    );
    $result = $statement->execute(
      array(
        ':id' => $_POST["remarque_id"]
      )
    );
    if ($statement->rowCount() > 0)
      print true;
    else
      print_r($statement->errorInfo());
  }
}
