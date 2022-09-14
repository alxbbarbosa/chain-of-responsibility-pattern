CONTAINER_NAME=alxbb_chain_of_responsibility_app
CONTAINER_DB_NAME=alxbb_chain_of_responsibility_db

docker-build:
	docker-compose build

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-logs:
	docker-compose logs --tail=0 --follow

docker-composer-install: docker-up
	docker exec -ti $(CONTAINER_NAME) composer install --no-interaction

docker-db:
	docker exec -ti $(CONTAINER_DB_NAME) mysql -uroot -p

docker-bash: docker-up
	docker exec -ti $(CONTAINER_NAME) bash

docker-clear: docker-up
	docker exec -ti $(CONTAINER_NAME) sh -c "php bin/console cache:clear"

docker-routes: docker-up
	docker exec -ti $(CONTAINER_NAME) sh -c "php bin/console debug:router"

docker-test: docker-up
	docker exec -ti $(CONTAINER_NAME) sh -c bin/phpunit

docker-test-coverage: docker-up docker-clear
	docker exec -e XDEBUG_MODE=coverage $(CONTAINER_NAME) vendor/bin/phpunit --testdox --coverage-html .reports/

docker-format: docker-up
	docker exec -ti $(CONTAINER_NAME) composer format

install-hooks:
	cp resources/scripts/pre-push .git/hooks/
	chmod +x .git/hooks/pre-push