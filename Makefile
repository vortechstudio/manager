PHONY: start

start:
	php artisan schedule:work
	php artisan pulse:work
	php artisan queue:work
	npm run dev

migrate:
	php artisan migrate:fresh --seed --force
	php artisan optimize
