#\bin\bash
source ./.env

DB_NAME="railway_beta"

php artisan service:locked
php artisan down

git reset --hard
git pull origin master

composer install --prefer-dist --no-interaction
npm install

php artisan migrate --force

php artisan release:update
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan clear
php artisan webpush:vapid
php artisan action daily_flux
php artisan action monthly_bonus
php artisan action daily_config
php artisan action daily_market_flux
chmod -R 777 storage bootstrap/cache

php artisan up
php artisan service:unlocked
