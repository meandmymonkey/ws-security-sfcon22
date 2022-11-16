.PHONY : help
help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: start
start: ## Starts docker environment
	docker-compose up -d

.PHONY: stop
stop: ## Stops docker environment
	docker-compose stop

.PHONY: cli
cli: ## Enters the PHP CLI
	docker-compose run --rm php /bin/bash

.PHONY: keys
keys: ## Generate JWT keys
	rm -f config/jwt/private.pem config/jwt/public.pem
	ssh-keygen -t rsa -b 4096 -m PEM -f config/jwt/private.pem -q -N ""
	openssl rsa -in config/jwt/private.pem -pubout -outform PEM -out config/jwt/public.pem

.PHONY: phpstan
phpstan: ## run phpstan
	./vendor/bin/phpstan analyze --xdebug

.PHONY: cs-check
cs-check: ## run php-cs-fixer
	php -d memory_limit=-1 ./vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: cs-fix
cs-fix: ## run php-cs-fixer
	php -d memory_limit=-1 ./vendor/bin/php-cs-fixer fix

