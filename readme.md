# Configuration  
## Requis  
- php >= 8.1  
- symfony >= 6.2  
- MySQL >= 8  
- Composer >= 2.2  
- Symfony CLI >= 5.4  
# Installation du projet  
## Cloner le repository github  
```bash
git clone https://github.com/ValM34/OP-DA-P7.git
```
## Installer les dépendances  
```bash
composer install
```
## Configurer le projet  
Créez un fichier .env.local à la racine de votre projet. Vous pouvez copier/coller le fichier .env pour avoir une base configurable.  
Pensez bien à remplir les informations à propos de votre système de gestion de base de données.  
## Créer la base de données  
```bash
symfony console doctrine:database:create
```
## Effectuer les migrations  
```bash
symfony console doctrine:migrations:migrate
```
## Ajouter des datafixtures (optionnel)  
L'ajout d'un jeu de données n'est pas recommandé en production.  
Pour ajouter des données initiales, tapez la commande suivante :  
```bash
php bin/console doctrine:fixtures:load
```
# Lancer le projet  
Saisissez la commande suivante :  
```bash
symfony serve
```
