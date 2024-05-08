#\bin\bash

php artisan down

git reset --hard
git pull origin master

composer install --prefer-dist --no-interaction
npm install

php artisan migrate:fresh --seed
php artisan optimize
php artisan view:clear
php artisan horizon:terminate
chmod -R 777 storage bootstrap/cache

php artisan up
