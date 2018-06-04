# ScrumManager 📌 

Cette application à destination de Natural Solutions permet de gérer l'ensemble du __Scrum__ de l'entreprise. C'est à dire "Créer des sprints", "Attribuer des heures", "Descendre des heures" et "Afficher la Burndownchat".

![presentation](https://user-images.githubusercontent.com/19387127/40916465-1df302fe-6800-11e8-90f6-d988fcf11ff1.gif)

## Pour Commencer..

Ces instructions vont vous permettre d'obtenir une copie du projet en cours sur votre machine.

### Prérequis

Vous aurais besoin au préalable d'installer

* [WampServer](http://www.wampserver.com/)

### Installation 💾 

__*1.  Installation de Wamp*__

1. Télécharger et installer Wamp. 
2. Lancer Wamp.
3. S'assurer que tous les services de Wamp sont lancés. (l'icone Wamp dans la barre de tache ne doit être ni orange, ni rouge mais bien verte)

__*2. Importation de l'application*__

1. Ouvrir le répertoir www de wamp. (Par defaut le répertoir ce situe à " C:\wamp64\www ")
2. Drag and drop le repository "ScrumManager" dans le répertoire www. 

__*3. Importation de la base de données*__

1. Lancer le service phpmyadmin de wamp. Aussi disponible en passant par " http://localhost/phpmyadmin/ "
 - Nom d'utilisateur : root
 - Mot de passe : 
2. Se diriger vers "import"
3. Choisir le fichier "ToutEnUn.sql" et exécuter. La base de données devrait se créer et se remplir d'un jeu de données du sprint 96 - 97 - 98 avec des heures attribuées et descendues.

 __*4. Paramétrer les infos de l'application*__

1. Ouvrir le fichier "Configs.php" situé dans "ScrumManager -> api -> www -> Configs.php".
2. Remplacer les infos des variables selon vos configurations. (si vous n'avez rien touché, tout devrait fonctionner sans changement nécessaire)

__*5. Une fois tout installé, paramétré, il est temps de tester l'application*__

1. Démarrer wamp.
2. Lancer l'application. Par défaut elle sera acccessible depuis un navigateur avec ce lien (http://localhost/ScrumManager/).

Vous voilà prêt à utiliser l'application.

## Bugs ? Erreurs ? 🐛

Pour toute erreur découverte, merci de la reporter dans la section erreur (https://github.com/Jeje2201/ScrumManager/issues/new)

## Développé avec 📦

* [JMerise](http://www.jfreesoft.com/JMerise/) - Outil de modélisation des MCD.
* [Bootstrap](http://getbootstrap.com/) - HTML, CSS, and JS framework.
* [DataTables](https://datatables.net/) - Plug-in pour la bibliothèque jQuery Javascript.
* [Datetimepicker](https://eonasdan.github.io/bootstrap-datetimepicker/) - Plugin pour avoir une sélection de date plus propre.
* [Highcharts](https://www.highcharts.com/) - Plugin pour créer les graph interactif.


## Autheur 👨‍💻

**[Leriche Jérémy](http://mrjeje.esy.es/)**

## Bootstrap Template 📄

__sb-admin__ ( [Site](https://startbootstrap.com/template-overviews/sb-admin/) | [Projet GitHub](https://github.com/BlackrockDigital/startbootstrap-sb-admin) )
