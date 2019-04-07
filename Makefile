PHPUNIT=./vendor/bin/phpunit
PHPCS=./vendor/bin/phpcs
PHPCBF=./vendor/bin/phpcbf
PHPSTAN=./vendor/phpstan/phpstan/bin/phpstan
INFECTION=./vendor/infection/infection/bin/infection

.PHONY: all

# Default target when just running 'make'
all: analyze test

vendor: composer.json composer.lock
	composer install

$(PHPUNIT): vendor
$(PHPCS): vendor
$(PHPCBF): vendor
$(PHPSTAN): vendor
$(INFECTION): vendor


.PHONY: test test-unit test-infection

test: test-unit test-infection

test-unit: $(PHPUNIT) vendor
	$(PHPUNIT) --coverage-text

test-infection: $(INFECTION) vendor build/logs
	$(INFECTION) --threads=4 --min-covered-msi=50


.PHONY: analyze cs-fix cs-check phpstan validate

analyze: cs-check phpstan validate

cs-fix: $(PHPCBF)
	$(PHPCBF) app --standard=phpcs.ruleset.xml

cs-check: $(PHPCS)
	$(PHPCS) app --standard=phpcs.ruleset.xml

phpstan: $(PHPSTAN)
	$(PHPSTAN) analyze app --level=3

validate:
	composer validate
