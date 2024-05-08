#\bin\bash

git reset --hard
git checkout $(git describe --tags `git rev-list --tags --max-count=1`)

composer install --prefer-dist --no-interaction
npm install

php artisan migrate --force
php artisan optimize
php artisan view:clear
php artisan horizon:terminate
