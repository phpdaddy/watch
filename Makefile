# Makefile for Docker Nginx PHP Composer MySQL

include .env

# MySQL
MYSQL_DUMPS_DIR=data/db/dumps

help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Commands:"
	@echo "  clean               Clean directories for reset"
	@echo "  docker-start        Create and start containers"
	@echo "  docker-stop         Stop and clear all services"
	@echo "  test                Test application"

init:
	@$(shell cp -n $(shell pwd)/web/.env.dist $(shell pwd)/web/.env 2> /dev/null)
	@docker run --rm -v $(shell pwd)/web:/app composer install

populatedb:
	#@docker-compose exec -T php ./bin/console doctrine:schema:update --force

clean:
	@rm -Rf data
	@rm -Rf web/vendor
	@rm -Rf web/composer.lock
	@rm -Rf web/doc
	@rm -Rf web/report
	@rm -Rf etc/ssl/*
	@rm -Rf web/.env

docker-start: init
	@docker-compose up -d

docker-stop:
	@docker-compose down -v
	@make clean

test: code-sniff
	@docker-compose exec -T php ./vendor/bin/phpunit --colors=always --configuration ./
