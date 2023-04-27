# Création du readme.md

### phpstan :  
PHPSTAN va analyser le code pour trouver des erreurs. Ca sert surtout pour le typage.  
Pour lancer une analyse sur src et tests, faire :  
```bash
vendor/bin/phpstan analyse src tests --level=6
```
Il n'est pas utile ni recommandé d'analyser le dossier vendor.  
Plus d'informations : https://phpstan.org/user-guide/getting-started  (lien ajouté le 12/04/2023)  

### PHP CS FIXER :  
PHP CS FIXER va analyser et <strong>modifier</strong> le code pour faire en sorte de respecter les conventions de codage et la syntaxe de PHP.  
Pour lancer PHP CS FIXER sur src (par exemple), lancez cette commande :  
```bash
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src
```

### PHP CODE SNIFFER :   
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

### PHP MD :   
PHP MD permet d'analyser le code, on peut analyser plusieurs choses et chsoisir ce qu'on analyse (pour d'informations : https://phpmd.org/documentation/index.html). Exemple de test sur le dossier src :  
```bash
php vendor/bin/phpmd src text codesize,unusedcode,naming
```

### Tests :  
Quelques commandes utiles pour générer les tests unitaires/fonctionnels :  
```bash
php bin/console doctrine:database:create --env=test
php bin/console doctrine:migrations:migrate --env=test
php bin/console doctrine:fixtures:load --env=test
```
Générer le rapport de couvertures de tests :  
```bash
vendor/bin/phpunit --coverage-html public/test-coverage
```
