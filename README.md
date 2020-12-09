# TP06 IACOBUCCI Clément

## Projet

Ce projet contient l'ensemble de l'application (Back + Front).

## Commandes

* Côté Front
  * npm install dans le dossier Front/

* Côté Back
  * composer install dans le dossier Back/
  
## Déploiement de l'application

VS Code a été utilisé. Pour effectuer les commandes suivantes, il suffit d'ouvrir un nouveau terminal dans l'éditeur de code.

* Côté Front
  * npm install dans le dossier Front/
  * ng serve 

* Côté Back
  * Le projet TP06_Back_Clement contient la partie Back de l'application de manière à la déployer sur Heroku.
    URL : tp06back.herokuapp.com
  * Pour passer en localhost, il suffit de décommenter la ligne "backendAPI" dans le fichier environment.ts puis :
    se placer dans le dossier Back/ et dans la console Powershell : php -S localhost:8080 -t public (on précise le dossier public car c'est dans ce dernier que se trouve
    le fichier index.php)
