	<?php
    $HostName = "localhost";
    $HostUsername = "root";
    $HostPassword = "";
    $BddTableName = "scrum";
    $ProjectFolderName = "ScrumManager";

    //Etablir la connexion pour les requetes ajax
    $connection = new PDO( 'mysql:host='.$HostName.';dbname='.$BddTableName.'', $HostUsername, $HostPassword ); 

    ?>