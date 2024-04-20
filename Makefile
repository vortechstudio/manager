PHONY: start

start:
	npm run dev
	php artisan schedule:work
	php artisan pulse:work
	php artisan queue:work

migrate:
	php artisan migrate:fresh --seed --force
	php artisan optimize
