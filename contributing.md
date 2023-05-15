Je vais vous expliquer comment contribuer à ce projet étape par étape.  
# Etape 1 : Créer une issue sur Github  
Chaque fois que vous souhaitez contribuer au projet, il faut créer une nouvelle issue.  
# Etape 2 : Créer une branche  
Après avoir créé votre issue, vous pouvez créer votre nouvelle branche. La branche prend l'identifiant de l'issue plus son titre. Chaque mot est séparé d'un "-". Les mots ne doivent par comporter de caractères spéciaux. Par exemple pour une issue dont le titre serait "Ajouter la possibilité de classer par ordre d'importance les tâches" et l'identifiant serait "87", on nommerait la branche "87-ajouter-la-possibilité-de-classer-par-ordre-d-importance-les-taches".   
# Etape 3 : Créer les tests avec phpunit  

Quelques commandes utiles pour générer les tests unitaires/fonctionnels :  
```bash
php bin/console doctrine:database:create --env=test
php bin/console doctrine:migrations:migrate --env=test
php bin/console doctrine:fixtures:load --env=test
```
Générer le rapport de couvertures de tests :  
```bash
vendor/bin/phpunit --coverage-html test-coverage
```
# Etape 4 : Lancer les analyses automatiques  
## phpstan  
PHPSTAN va analyser le code pour trouver des erreurs. Ca sert surtout pour le typage.  
Il faut configurer le fichier phpstan.neon à la base du projet.  
Pour lancer une analyse sur src et tests, faire :  
```bash
vendor/bin/phpstan
```
Plus d'informations : https://phpstan.org/user-guide/getting-started  (lien ajouté le 12/04/2023)  
## phpmd  
PHP MD permet d'analyser le code, on peut analyser plusieurs choses et chsoisir ce qu'on analyse (pour d'informations : https://phpmd.org/documentation/index.html). Exemple de test sur le dossier src :  
```bash
php vendor/bin/phpmd src text phpmd.xml
```
Configurable à la racine du projet dans phpmd.xml  
## php code sniffer  
PHP CODE SNIFFER est un outil d'analyse de la syntaxe et des conventions en php. Il ne modifie pas le code directement. L'utilisation de PHP CS FIXER n'empêche pas celle de PHP CODE SNIFFER car même après avoir utilisé PHP CS FIXER vous pourrez trouver beaucoup d'erreurs avec PHP CODE SNIFFER.  
Pour l'utiliser, je l'ai installé de manière globale sur ma machine, il n'est donc pas présent de base sur le projet.  
Pour lancer une analyse sur src (par exemple), lancez cette commande :  
```bash
phpcs src
```
Pour vérifier une convention précise (par exemple PSR12 pour src), lancez cette commande :  
```bash
phpcs --standard=PSR12 src
```
Pour fixer cette même convention : 
```bash
phpcbf --standard=PSR12 src
```
# Etape 5 : pull request  
Vous pouvez créer une pull request directement depuis github. La base est la branche "main" et compare est votre branche.  
## Code review  
Si besoin le lead dev fera un code review de la fonctionnalité.  
## Analyse automatique de Symfony Insight  
Avant de valider la pull request, il faudra vérifier que symfony insight ne détecte pas de nouvelle erreur sur le code. C'est directement visible depuis github dans la page de la pull request.  
## Validation de la pull request  
Une fois que symfony insight a réalisé son analyse et que plus aucun erreur n'est détectée, vous pouvez valider la pull request. Vous devez ajouter un commentaire qui contiendra un lien vers l'issue liée à la fonctionnalité.  
Pour le faire il suffit d'écrire l'identifiant de l'issue. Par exemple si c'est #26 alors il faudra écrire #26.
# Etape 6 : Fermer l'issue  
Avant de fermer l'issue, il faut faire un commentaire pour ajouter le lien (de la même manière qu'expliqué ci-dessus) vers la pull request.  
