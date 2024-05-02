build:
	docker-compose build --no-cache
upd:
	docker-compose up -d
ps:
	docker-compose ps
down:
	docker-compose down
login:
	docker exec -it sample-app bash
optimize:
	docker exec -it sample-app php artisan optimize
migrate:
	docker exec -it sample-app php artisan migrate
seed:
	docker exec -it sample-app php artisan db:seed
key:
	docker exec -it sample-app php artisan key:generate
swagger:
	docker exec -it sample-app php artisan l5-swagger:generate
composer-install:
	docker exec -it sample-app composer install
composer-dump:
	docker exec -it sample-app composer dump-autoload
route-list:
	docker exec -it sample-app php artisan route:list
fresh-migrate:
	docker exec -it sample-app php artisan migrate:fresh
