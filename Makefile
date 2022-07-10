# enable to pass arguments
%:
	@:
ARGS = `arg="$(filter-out $@, $(MAKECMDGOALS))" && echo $${arg:-${1}}`
USER_NAME := $(USER)
TARGET_FILE = "docker-compose-multi-services"

# rules for docker-compose-multi-services
run:
	@SUBNET_NETWORK_ID_SUFFIX=$(call ARGS,1) USER=$(USER_NAME) docker-compose -f $(TARGET_FILE) up -d
kill:
	USER=$(USER_NAME) docker-compose -f $(TARGET_FILE) down -v
refresh:
	@USER=$(USER_NAME) docker-compose -f $(TARGET_FILE) down -v && \
	USER=$(USER_NAME) docker-compose -f $(TARGET_FILE) pull --ignore-pull-failures && \
	SUBNET_NETWORK_ID_SUFFIX=$(call ARGS,1) USER=$(USER_NAME) docker-compose -f $(TARGET_FILE) up -d

############ old rules

DC_FILENAME = docker-compose.yml
DC_FILENAME_MAC = docker-compose-for-mac.yml
USER := $(shell id -u)
GROUP := $(shell id -g)
WHOAMI = $(USER):$(GROUP)

.PHONY: build kill clean exec composer

build:
	docker compose -f $(DC_FILENAME) up -d

kill:
	docker compose -f $(DC_FILENAME) down

build-mac:
	docker compose -f $(DC_FILENAME_MAC) up -d

kill-mac:
	docker compose -f $(DC_FILENAME_MAC) down

kill-mac-vol:
	docker compose -f $(DC_FILENAME_MAC) down -v

clean-vol:
	docker volume rm -f $(docker volume ls -q)

terminal:
	docker exec -it fpm-app /bin/sh

composer-install:
	docker compose exec app composer install \
	--no-cache --ignore-platform-reqs
