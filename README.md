# Forge-de-Heros

composer install

cp .env .env.local

ouvrer le fichier .env.local
décommenter : DATABASE_URL="sqlite:///%kernel.project_dir%/var/data_%kernel.environment%.db"
puis commenter : DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8" avec un #

puis dans la console :

php bin/console doctrine:migration:migrate

php bin/console doctrine/fixtures:load

symfony serve