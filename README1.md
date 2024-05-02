# [Server] information
- NGINX version: 1.23.0
- PHP version: 8.0.2
- Laravel version: 9.19
- MySQL version: 8.0

## [Build]
- `cp .env.example .env`
- `docker-compose build`
- `docker-compose up -d`
- `docker exec -it sample-app php artisan migrate`
- `docker exec -it sample-app php artisan db:seed`
- `docker exec -it sample-app php artisan optimize`

## [Swagger]
- run: `docker exec -it sample-app php artisan l5-swagger:generate`
- access: `http://localhost:8038/api/v1/documentation`

## [App] usage basic commands
- Build server: `docker-compose up --build`
- Start server: `docker-compose up -d`
- Stop server: `docker-compose stop`
- Down server: `docker-compose down`
- Access to app server: `docker exec -it app bash`
- Access to DB server: `docker exec -it mysql bash`
- Run migration: `docker exec -it app php artisan migrate`
- Clear cache server: `docker exec -it app php artisan optimize:clear`
- Generate key: `docker exec -it app php artisan key:generate`
- Autoload(Execute when class is changed): `docker exec -it app php composer dump-autoload`
- Run Seeder: `docker exec -it app php artisan db:seed`

## [Schedule]
* * * * * php path-to-project/artisan schedule:run >> /dev/null 2>&1

### [Deployment]:
Application deploy:
- `./vendor/bin/dep deploy (dev|demo|prod) --(tag|branch)=xxx`

Application enable maintain mode:
- `./vendor/bin/dep artisan:down (dev|demo|prod)`

Application disable maintain mode:
- `./vendor/bin/dep artisan:up (dev|demo|prod)`

Database execute|update tables:
- `./vendor/bin/dep artisan:migrate (dev|demo|prod)`

PHP-FPM reload:
- `./vendor/bin/dev php-fpm:reload (dev|demo|prod)`

Note: Modify hosts can also be described by using yaml syntax.
