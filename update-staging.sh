#\bin\bash
source ./.env

DB_NAME="railway_beta"
DB_USER="debian"
DB_PASS="rbU89a-4"

php artisan service:locked
php artisan down

git reset --hard
git pull origin master

composer install --prefer-dist --no-interaction
npm install

mysql -u "$DB_USER" -p"$DB_PASS" -Nse 'show tables' "$DB_NAME" | while read table; do mysql -u "$DB_USER" -p"$DB_PASS" -e "drop table $table" "$DB_NAME"; done

php artisan migrate:fresh --seed --force

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
