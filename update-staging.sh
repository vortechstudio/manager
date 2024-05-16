#\bin\bash

php artisan service:locked
php artisan down

git reset --hard
git pull origin master

composer install --prefer-dist --no-interaction
npm install

# shellcheck disable=SC1073
if [ "$(git diff --name-only HEAD HEAD~1 -- database/migration)" != ""]
then
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
