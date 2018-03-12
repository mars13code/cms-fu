# cms-fu

Construire un CMS en langage PHP avec des fonctions

* utiliser les techniques de PHP7 
* qui permettent une programmation fonctionnelle avancée
* variables static de fonctions
* nombre variable de paramètres pour les fonctions
* ...et aussi SQL... sans ORM!


## Prérequis

La plupart des hébergements web mutualisés proposent un serveur LAMP

* Serveur web LAMP, WAMP, MAMP, XAMP, etc...
* PHP7
* MySQL5

Conseils:
* prendre un hébergement avec accès SSH et https inclus
* (...prix actuels autour de 5 euros/mois)

## Installation

Ne pas oublier de changer les fichiers dans le dossier /public/
* pour adapter les chemins vers le dossier racine du site
* pour adapter les infos de connexion à MySQL

* public/index.php

Et si vous utilisez un serveur web LAMP (avec Apache)

* public/.htaccess


## Architecture MVC

Le code suit au possible le Design Pattern MVC pour permettre une meilleure
réutilisation et évolution du code

* Plugins: étendre les possibilités
* Themes: modifier l'apparence visuelle suivant le projet
* Actions et Filtres: interactions entre le CMS, le thème et les plugins

## Architecture: usage de MySQL

Pour permettre une grande flexibilité du CMS

Il est nécessaire d'effectuer plusieurs lectures successives avec MySQL

* lecture des etapes du framework
* lecture de la page a afficher
* lecture des contenus de la page (menu, blocs, etc...)

### PDO et requêtes préparées 

Pour bloquer les attaques par injection SQL, 
il vaut mieux éviter de concaténer ses requêtes SQL avec des parties extérieures...
