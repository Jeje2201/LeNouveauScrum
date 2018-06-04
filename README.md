# ScrumManager

Cette application à destination de Natural Solutions permet de gérer l'ensemble du __Scrum__ de l'entreprise. C'est à dire "Créer des sprints", "Attribuer des heures", "Descendre des heures" et "Afficher la Burndownchat".

## Pour Commencer..

Ces instructions vont vous permettre d'obtenir une copie du projet en cours sur votre machine.

### Prérequis

Vous aurais besoin au préalable d'installer

* [WampServer](http://www.wampserver.com/)

### Installation

__*Installation de Wamp*__

1. Télécharger Wamp. 
2. Installer wamp par son .exe
3. Une fois correctement installé, lancer Wamp.
4. S'assurer que tous les services sont lancés. (l'icone ne doit être ni orange, ni rouge mais bien verte)

__*Importation de l'application*__

1. Ouvrir le répertoir www de wamp. (Par defaut le répertoir ce situe à " C:\wamp64\www ")
2. Drag and drop le repository "ScrumManager" dans le répertoire www. 

__*Importation de la base de données*__

1. Lancer le service phpmyadmin de wamp. Disponible aussi en passant par " http://localhost/phpmyadmin/ "
 - Nom d'utilisateur : root
 - Mot de passe : 
2. Se diriger vers "import"
3. Choisir le fichier "ToutEnUn.sql" et exécuter. La base de données devrait se créer et se remplir d'un jeu de données du sprint 96 - 97 - 98.

__*Paramétrer les infos de l'application*__

1. Ouvrir le fichier "Configs.php" situé dans "ScrumManager -> api -> www -> Configs.php".
2. Remplacer les infos des variables selon vos configurations. (si vous n'avez rien touché, tout devrait fonctionner sans changement nécessaire)

__*Une fois tout installé, paramétré, il est temps de tester l'application*__

1. Démarrer wamp.
2. Lancer l'application. Par défaut elle sera acccessible depuis un navigateur avec ce lien (http://localhost/ScrumManager/).

Vous voilà prêt à utiliser l'application.

## Choses à faire

Voici une liste de foncionalitées qui je pense seraient bien à ajouter à l'application dans un futur : 

  - Permettre la **suppression** et **modification** de données
    - Des sprints.
    - Des heures attribuées.
    - Des heures descendues.
  - Améliorer la connexion à la base de données depuis les différentes page et les méthodes pour receuillir les données style MVC ?.

## Développé avec

* [JMerise](http://www.jfreesoft.com/JMerise/) - Outil de modélisation des MCD.
* [Bootstrap](http://getbootstrap.com/) - HTML, CSS, and JS framework.
* [DataTables](https://datatables.net/) - Plug-in for the jQuery Javascript library.
* [Highcharts](https://www.highcharts.com/) - Plugin to set up interactive charts.

## Autheur

* **[Leriche Jérémy](http://mrjeje.esy.es/)** - *Travail initial*




## Template utilisé

__sb-admin__ ( [Site](https://startbootstrap.com/template-overviews/sb-admin/) | [Projet GitHub](https://github.com/BlackrockDigital/startbootstrap-sb-admin) )
