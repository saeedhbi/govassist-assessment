default: init

init:
	make run-d
	make install
	make build
	docker-compose exec -u www-data front php artisan key:generate
	docker-compose exec -u www-data front php artisan migrate --force

run:
	docker-compose up

run-d:
	docker-compose up -d

stop:
	docker-compose down

exec:
	docker-compose exec -u www-data front bash

build:
	docker-compose exec -u www-data front yarn build

watch:
	docker-compose exec -u www-data front yarn dev

install:
	docker-compose exec -u www-data front composer install
	docker-compose exec -u www-data front yarn install

clear:
	docker-compose exec -u www-data front php artisan optimize:clear
	docker-compose exec -u www-data front truncate -s 0 ./storage/logs/laravel.log
	docker-compose exec -u www-data front rm -rf ./public/build

flush:
	make clear
	docker-compose exec -u www-data front rm -rf ./vendor
	docker-compose exec -u www-data front rm -rf ./node_modules
