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
	cp -r app/Actions/Railway ../dev.railway-manager/app/Actions/

sync_s3_beta:
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/blog' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/cercles' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/data' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/engines' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/events' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/icons' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/logos' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/other' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/pwa' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/
	rsync -avz --info=progress2 --delete '../s3.vortechstudio/services' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.ovh/

sync_s3:
	rsync -az --info=progress2 --delete '../s3.vortechstudio/blog' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/
	rsync -az --info=progress2 --delete '../s3.vortechstudio/cercles' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/
	rsync -az --info=progress2 --delete '../s3.vortechstudio/data' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/
	rsync -az --info=progress2 --delete '../s3.vortechstudio/engines' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/
	rsync -az --info=progress2 --delete '../s3.vortechstudio/events' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/
	rsync -az --info=progress2 --delete '../s3.vortechstudio/icons' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/
	rsync -az --info=progress2 --delete '../s3.vortechstudio/logos' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/
	rsync -az --info=progress2 --delete '../s3.vortechstudio/other' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/
	rsync -az --info=progress2 --delete '../s3.vortechstudio/pwa' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/
	rsync -az --info=progress2 --delete '../s3.vortechstudio/services' -e 'ssh -p 5678' access@37.187.117.190:/www/wwwroot/s3.vortechstudio.fr/

prepare: sync_s3 sync_s3_beta sync_database
	npm run build
	./vendor/bin/pint app/
	./vendor/bin/rector process app
	git add .
	git commit -m "style(General): Correction syntaxique du programme"
	git push origin develop

