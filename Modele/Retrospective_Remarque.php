<?php
session_start();
require_once('Configs.php');

if (isset($_POST["action"])) {

  if ($_POST["action"] == "getRemarques") {
    $statement = $connection->prepare("SELECT *
        FROM retrospective_remarque
        ORDER BY retrospective_remarque_dateFini IS NULL ASC, retrospective_remarque_dateFini ASC");

    $statement->execute();
    $result = $statement->fetchAll();

    print json_encode($result);
  }

  if ($_POST["action"] == "getRemarque") {

    $statement = $connection->prepare(
      "SELECT *
      FROM retrospective_remarque 
      WHERE retrospective_remarque_pk = '" . $_POST["remarque_id"] . "' 
      LIMIT 1"
    );
    $statement->execute();
    $result = $statement->fetch();

    print json_encode($result);
  }

  if ($_POST["action"] == "achieveRetrospective") {
    $statement = $connection->prepare(
      "UPDATE retrospective_remarque 
      SET retrospective_remarque_dateFini = NOW()
      WHERE retrospective_remarque_pk = :id
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

    if ($_POST["remarque_DateFini"] == "")
      $_POST["remarque_DateFini"] = null;

    $statement = $connection->prepare("
   INSERT INTO retrospective_remarque (retrospective_remarque_label, retrospective_remarque_user, retrospective_remarque_dateCreation, retrospective_remarque_dateFini) 
   VALUES (:Label, :User, :DateCreation, :DateFin)
   ");
    $result = $statement->execute(
      array(
        ':Label' => $_POST["Labelretrospective"],
        ':User' => $_POST["Userretrospective"],
        ':DateCreation' => $_POST["remarque_DateDebut"],
        ':DateFin' => $_POST["remarque_DateFini"]
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
      SET retrospective_remarque_label = :remarque_label,
      retrospective_remarque_user = :remarque_user,
      retrospective_remarque_dateCreation = :remarque_DateDebut,
      retrospective_remarque_dateFini = :remarque_DateFin
      WHERE retrospective_remarque_pk = :remarque_id"
    );
    $result = $statement->execute(
      array(
        ':remarque_label' => $_POST["remarque_label"],
        ':remarque_user' => $_POST["remarque_user"],
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
         WHERE retrospective_remarque_pk = :id"
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
