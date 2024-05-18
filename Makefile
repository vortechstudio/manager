PHONY: start

start:
	php artisan schedule:work
	php artisan pulse:work
	php artisan queue:work
	npm run dev

migrate:
	mysql -u root -p  -e "\
    	DROP DATABASE IF EXISTS railway_dev; \
    	CREATE DATABASE railway_dev; \
    	"
	php artisan migrate:fresh --seed --force
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear
	php artisan clear
	php artisan release:update
	php artisan action daily_flux
	php artisan action monthly_bonus
	php artisan action daily_config
	php artisan create level

sync_database:
	cp -r database/migrations ../dev.railway-manager/database/
	cp -r app/Models ../dev.railway-manager/app/
	cp -r app/Enums ../dev.railway-manager/app/
