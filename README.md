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
2. Drag and drop le repository "LeNouveauScrum" dans le répertoire www. 

__*Importation de la base de données*__

1. Lancer le service phpmyadmin de wamp. Disponible aussi en passant par " http://localhost/phpmyadmin/ "
 - Nom d'utilisateur : root
 - Mot de passe : 
2. Se diriger vers "import"
3. Choisir le fichier "ToutEnUn.sql" et exécuter. La base de données devrait se créer et se remplir d'un jeu de données du sprint 96 - 97 - 98.

__*Paramétrer les infos de l'application*__

(Les parties suivante ne sont pas encore totalement opérationelles, et pour cause, toutes modifications ne seront pas importés dans tous les fichiers php, veuillez donc garder les paramètres de wamp par défaut pour le moment).
1. Ouvrir le dossier "LeNouveauScrum".
2. Ouvrir le fichier "header.php".
3. Editer la ligne
  - $host = "localhost";
En remplacant "localhost" si vous avez éditez vos configurations par défaut.
4. Editer la ligne
  - $conn = new mysqli('localhost', 'root', '', 'scrum') 
  Si vous avez changé vos informations de connexion à la base de donnée et son nom.

__*Une fois tout installé, paramétré, il est temps de tester l'application*__

1. Démarrer wamp.
2. Lancer l'application. Par défaut elle sera acccessible depuis un navigateur avec ce lien (http://localhost/LeNouveauScrum/).

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




# ▼ ReadMe officiel du template ▼

## [Start Bootstrap - SB Admin](https://startbootstrap.com/template-overviews/sb-admin/)

[SB Admin](http://startbootstrap.com/template-overviews/sb-admin/) is an open source, admin dashboard template for [Bootstrap](http://getbootstrap.com/) created by [Start Bootstrap](http://startbootstrap.com/).

## Preview

[![SB Admin Preview](https://startbootstrap.com/assets/img/templates/sb-admin.jpg)](https://blackrockdigital.github.io/startbootstrap-sb-admin/)

**[View Live Preview](https://blackrockdigital.github.io/startbootstrap-sb-admin/)**

## Status

[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/BlackrockDigital/startbootstrap-sb-admin/master/LICENSE)
[![npm version](https://img.shields.io/npm/v/startbootstrap-sb-admin.svg)](https://www.npmjs.com/package/startbootstrap-sb-admin)
[![Build Status](https://travis-ci.org/BlackrockDigital/startbootstrap-sb-admin.svg?branch=master)](https://travis-ci.org/BlackrockDigital/startbootstrap-sb-admin)
[![dependencies Status](https://david-dm.org/BlackrockDigital/startbootstrap-sb-admin/status.svg)](https://david-dm.org/BlackrockDigital/startbootstrap-sb-admin)
[![devDependencies Status](https://david-dm.org/BlackrockDigital/startbootstrap-sb-admin/dev-status.svg)](https://david-dm.org/BlackrockDigital/startbootstrap-sb-admin?type=dev)

## Download and Installation

To begin using this template, choose one of the following options to get started:
* [Download the latest release on Start Bootstrap](https://startbootstrap.com/template-overviews/sb-admin/)
* Install via npm: `npm i startbootstrap-sb-admin`
* Clone the repo: `git clone https://github.com/BlackrockDigital/startbootstrap-sb-admin.git`
* [Fork, Clone, or Download on GitHub](https://github.com/BlackrockDigital/startbootstrap-sb-admin)

## Usage

### Basic Usage

After downloading, simply edit the HTML and CSS files included with the template in your favorite text editor to make changes. These are the only files you need to worry about, you can ignore everything else! To preview the changes you make to the code, you can open the `index.html` file in your web browser.

### Advanced Usage

After installation, run `npm install` and then run `gulp dev` which will open up a preview of the template in your default browser, watch for changes to core template files, and live reload the browser when changes are saved. You can view the `gulpfile.js` to see which tasks are included with the dev environment.

#### Gulp Tasks

- `gulp` the default task that builds everything
- `gulp dev` browserSync opens the project in your default browser and live reloads when changes are made
- `gulp sass` compiles SCSS files into CSS
- `gulp minify-css` minifies the compiled CSS file
- `gulp minify-js` minifies the themes JS file
- `gulp copy` copies dependencies from node_modules to the vendor directory

## Bugs and Issues

Have a bug or an issue with this template? [Open a new issue](https://github.com/BlackrockDigital/startbootstrap-sb-admin/issues) here on GitHub or leave a comment on the [template overview page at Start Bootstrap](http://startbootstrap.com/template-overviews/sb-admin/).

## Custom Builds

You can hire Start Bootstrap to create a custom build of any template, or create something from scratch using Bootstrap. For more information, visit the **[custom design services page](https://startbootstrap.com/bootstrap-design-services/)**.

## About

Start Bootstrap is an open source library of free Bootstrap templates and themes. All of the free templates and themes on Start Bootstrap are released under the MIT license, which means you can use them for any purpose, even for commercial projects.

* https://startbootstrap.com
* https://twitter.com/SBootstrap

Start Bootstrap was created by and is maintained by **[David Miller](http://davidmiller.io/)**, Owner of [Blackrock Digital](http://blackrockdigital.io/).

* http://davidmiller.io
* https://twitter.com/davidmillerskt
* https://github.com/davidtmiller

Start Bootstrap is based on the [Bootstrap](http://getbootstrap.com/) framework created by [Mark Otto](https://twitter.com/mdo) and [Jacob Thorton](https://twitter.com/fat).

## Copyright and License

Copyright 2013-2017 Blackrock Digital LLC. Code released under the [MIT](https://github.com/BlackrockDigital/startbootstrap-sb-admin/blob/gh-pages/LICENSE) license.
