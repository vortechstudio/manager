#\bin\bash
php artisan down
php artisan service:locked

git reset --hard
git checkout $(git describe --tags `git rev-list --tags --max-count=1`)

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
php artisan horizon:terminate
php artisan action daily_flux
php artisan action monthly_bonus
php artisan action daily_config
chmod -R 777 storage bootstrap/cache

php artisan service:unlocked
php artisan up
