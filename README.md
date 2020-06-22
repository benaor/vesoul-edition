# CE PROJET A ETE REALISE PAR BENJAMIN GIRARD, DANS LE CADRE D'UN STAGE POUR ACCESS CODE SCHOOL
# FOR JOIN THE DEVELOPEMENT : 
Download or clone the repository. 

running "composer install" for install dépendances.

running "yarn install" for install yarn dependances.

Edit ".env" for acces to the database. 

Create database with "php bin/console doctrine:database:create"

execute migration with "php bin/console doctrine:migrations:migrate"

Executes this command for install the fixtures bundles "composer require --dev doctrine/doctrine-fixtures-bundle"

fill database's tables "php bin/console doctrine:fixtures:load"