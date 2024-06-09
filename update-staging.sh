#\bin\bash
source ./.env

DB_NAME="railway_beta"

php artisan service:locked
php artisan down

git reset --hard
git pull origin master

composer install --prefer-dist --no-interaction
npm install

# Créer un fichier temporaire
SQL_FILE=$(mktemp)
# Générer les instructions SQL pour supprimer les tables
echo "SET FOREIGN_KEY_CHECKS = 0;" > $SQL_FILE
mysql --defaults-extra-file=/etc/my.cnf -Nse 'SHOW TABLES' "$DB_NAME" | while read table; do echo "DROP TABLE IF EXISTS $table;" >> $SQL_FILE; done
echo "SET FOREIGN_KEY_CHECKS = 1;" >> $SQL_FILE
# Exécuter les instructions SQL dans une seule session mysql
mysql --defaults-extra-file=/etc/my.cnf $DB_NAME < $SQL_FILE
# Supprimer le fichier temporaire
rm $SQL_FILE

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
