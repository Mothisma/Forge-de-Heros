# Forge-de-Heros

dans la console :

composer install

cp .env .env.local

puis ouvrir le fichier .env.local

et décommenter : DATABASE_URL="sqlite:///%kernel.project_dir%/var/data_%kernel.environment%.db"
ensuite commenter : DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8" avec un #

puis dans la console :

php bin/console doctrine:migration:migrate

php bin/console doctrine:fixtures:load

yes

ouvrir le dossier php.ini

enlever le ; a la ligne : extension=fileinfo

pour finir en console :

symfony serve
