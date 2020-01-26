<html>

<body>
    <?php

    //Fonction pour enlever les accents
    function stripAccents($str)
    {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    //Création de la variable qui sera composé de tous les mails
    $ListeMail = "";

    //Etablir la connexion pour les requetes ajax
    $connection = new PDO('mysql:host=localhost;dbname=scrum;charset=utf8', 'jeremy', 'Spiderman2008');

    //Requete sql qui sort les adresses des gens ET les jours de la semaine en numeric
    $statement = $connection->prepare(
        $sql = "SELECT X.mail as 'LesMails'
    from employe X
    where X.id not in (SELECT
        C.Fk_User
        FROM fiche_de_temps C
        where C.Done like DATE_FORMAT(now(), '%Y-%m-%d')
        group by C.Done, C.Fk_User
        having sum(C.Time) = 444)
    and X.MailCir = 1
    order by LesMails"
    );

    //Executer la requete sql
    $statement->execute();

    //Faire une boucle pour chaque resultat
    $result = $statement->fetchAll();

    $Citation = array(
        "Mon cerveau est mon deuxième organe préféré. (Frédéric)", "Être ou ne pas être alors ne pas être. (Nabil)", "Mieux vaux fermer sa gueule et passer pour un con, que de l'ouvrir et ne laisser aucun doute à ce sujet. (Herve)", "Un grand pouvoir entraîne de grandes irresponsabilités. (Jérémy)", "Et l'immateriel est à présent immatériel. (Garance)", "Trop de paperasse, trop d'administratif : ça tue ! (Amine)", "Mieux vaut marcher lentement dans la bonne direction que de courir dans la mauvaise. (Théa)", "Pour vivre longtemps, à son cul il faut donner vent. (Angélique)"
    );

    //En tete pour prendre l'utf8 et le css
    $EnTete = "From: \"Natural Recall\"<jeremy@vps609393.ovh.net>\n";
    $EnTete .= "Content-Type: text/html; charset=\"UTF-8\"";

    //Objet du mail
    $Objet = "Oublie feuille de temps du " . date("d/m/y");

    //Le message à envoyer
    $Message = "<p>Il semble que vous ayez oublié de remplir votre feuille de temps du " . date("d/m/y")   . " ? Merci de prendre le temps rectifier cela <a href=\"https://scrummanager.natural-solutions.eu/index.php?vue=FicheDeTemps\">ici</a></p><i>" . $Citation[rand(0, count($Citation) - 1)] . "</i>";

    //Use wordwrap() if lines are longer than 70 characters
    $Message = wordwrap($Message, 70);

    //Pour chaque adresse trouvé
    foreach ($result as $row) {

        //send email
        mail(stripAccents($row['LesMails']), $Objet, $Message, $EnTete);
        $ListeMail .= $row['LesMails'];
        $ListeMail .= '<br>';
    }

    echo (stripAccents($ListeMail));
    ?>

</body>

</html>