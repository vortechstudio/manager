#\bin\bash
source .env

php artisan service:locked
php artisan down

git reset --hard
git pull origin master

composer install --prefer-dist --no-interaction
npm install

if [ "$(git diff --name-only HEAD HEAD~1 -- database/migrations)" != "" ]
then
    mysql -u votre_nom_utilisateur -p votre_mot_de_passe -e "

    # Suppression de la base de données
    DROP DATABASE IF EXISTS ${DB_RAILWAY_DATABASE};

    # Création de la base de données
    CREATE DATABASE ${DB_RAILWAY_DATABASE};
    "
    php artisan migrate:fresh --seed
fi

php artisan release:update
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan clear
php artisan webpush:vapid
php artisan horizon:terminate
chmod -R 777 storage bootstrap/cache

php artisan up
php artisan service:unlocked
