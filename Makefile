PHPUNIT=./vendor/bin/phpunit
PHPCS=./vendor/bin/phpcs
PHPCBF=./vendor/bin/phpcbf
PHPSTAN=./vendor/phpstan/phpstan/bin/phpstan

.PHONY: all

# Default target when just running 'make'
all: analyze test

vendor: composer.json composer.lock
	composer install

$(PHPUNIT): vendor
$(PHPCS): vendor
$(PHPCBF): vendor
$(PHPSTAN): vendor


.PHONY: test test-unit test-infection

test: test-unit test-infection

test-unit: $(PHPUNIT) vendor
	$(PHPUNIT) --coverage-text


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
