    <?php

    require_once('Configs.php');

    //Fonction pour enlever les accents
    function stripAccents($str)
    {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    //Requete sql qui sort les adresses des gens ET les jours de la semaine en numeric
    $statement = $connection->prepare(
        $sql = "SELECT user_mail
        from user
        where user_pk not in (SELECT
        fiche_de_temps_fk_user
        FROM fiche_de_temps
        where fiche_de_temps_done like DATE_FORMAT(now(), '%Y-%m-%d')
        group by fiche_de_temps_done, fiche_de_temps_fk_user
        having sum(fiche_de_temps_time) = 444)
    and user_mailCir = 1
    order by user_mail"
    );

    //Executer la requete sql
    $statement->execute();

    //Faire une boucle pour chaque resultat
    $result = $statement->fetchAll();

    $Citation = array(
        "Mon cerveau est mon deuxième organe préféré. (Frédéric B.)",
        "Être ou ne pas être alors ne pas être. (Nabil H.)",
        "Mieux vaux fermer sa gueule et passer pour un con, que de l'ouvrir et ne laisser aucun doute à ce sujet. (Hervé A.)",
        "Un grand pouvoir entraîne de grandes irresponsabilités. (Jérémy L.)",
        "Et l'immateriel est à présent immatériel. (Garance L.)",
        "Trop de paperasse, trop d'administratif : ça tue ! (Amine H.)",
        "Mieux vaut marcher lentement dans la bonne direction que de courir dans la mauvaise. (Théa A.)",
        "Ce n'est pas la destination qui compte mais le chemin parcouru. (Laura A.)",
        "Pour vivre longtemps, à son cul il faut donner vent. (Angélique R.)"
    );

    //En tete pour prendre l'utf8 et le css
    $EnTete = "From: \"Natural Recall\"<jeremy@vps609393.ovh.net>\n";
    $EnTete .= "Content-Type: text/html; charset=\"UTF-8\"";

    //Objet du mail
    $Objet = "Oublie feuille de temps du " . date("d/m/y");

    //Le message à envoyer
    $Message = "<p>Il semble que tu as oublié de remplir ta feuille de temps du " . date("d/m/y")   . " ? N'oublie pas de la remplir ou tu vas surement oublier ce que t'as fait, <a href=\"https://scrummanager.natural-solutions.eu/index.php?vue=FicheDeTemps\">ici</a></p><i>" . $Citation[rand(0, count($Citation) - 1)] . "</i>";

    //Use wordwrap() if lines are longer than 70 characters
    $Message = wordwrap($Message, 70);

    //Pour chaque adresse trouvé
    foreach ($result as $row) {

        //send email
        mail(stripAccents($row['user_mail']), $Objet, $Message, $EnTete);
    }

    ?>