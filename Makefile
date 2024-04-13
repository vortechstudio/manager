PHONY: start

start:
	npm run dev
	php artisan schedule:work
	php artisan pulse:work
	php artisan queue:work
