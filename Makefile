.PHONY: deps fmt up setup down

ifneq (,$(wildcard ./.env))
    include .env
    export
endif

deps:
	composer install

fmt:
	vendor/bin/php-cs-fixer fix public --rules=@PSR12
	vendor/bin/php-cs-fixer fix src --rules=@PSR12

up:
	docker compose up -d --build

setup:
	docker compose exec -T mysql sh -c 'exec mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" --default-character-set=utf8mb4 ${MYSQL_DATABASE}' < dump/products.sql
	docker compose exec -T mysql sh -c 'exec mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" --default-character-set=utf8mb4 ${MYSQL_DATABASE}' < dump/user.sql
	docker compose exec -T mysql sh -c 'exec mysql -uroot -p"${MYSQL_ROOT_PASSWORD}" --default-character-set=utf8mb4 ${MYSQL_DATABASE}' < dump/user_order.sql

down:
	docker compose down --remove-orphans

shell:
	docker compose exec php sh

serve:
	php -S 127.0.0.1:${PORT} public/index.php
