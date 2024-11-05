install:
	composer update
	php artisan db:wipe
	php artisan migrate:install
	php artisan key:generate
	php artisan schema:dump
	php artisan migrate:fresh
	php artisan db:seed

db:
	make migrate
	make seed

migrate:
	php artisan migrate

seed:
	php artisan db:seed

prepare:
	php composer.phar install
	php artisan migrate
	php artisan db:seed

permissions:
	chmod -R 775 ./bootstrap
	chmod -R 775 ./storage

logs:
	tail -n 100 -f storage/logs/laravel.log
