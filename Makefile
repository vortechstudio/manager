PHONY: start

start:
	php artisan schedule:work
	php artisan pulse:work
	php artisan queue:work
	npm run dev

migrate:
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
