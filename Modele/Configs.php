	<?php
    $HostName = "localhost";
    $HostUsername = "root";
    $HostPassword = "";
    $BddTableName = "scrum";
    $ProjectFolderName = "ScrumManager";
    
    $conn = new mysqli($HostName, $HostUsername, $HostPassword, $BddTableName) 
    or die ('Cannot connect to db');
    ?>