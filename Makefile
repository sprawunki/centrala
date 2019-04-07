PHPUNIT=./vendor/bin/phpunit
PHPA=./vendor/bin/phpa
PHPCS=./vendor/bin/phpcs
PHPCBF=./vendor/bin/phpcbf
PHPMD=./vendor/bin/phpmd
PHPSTAN=./vendor/phpstan/phpstan/bin/phpstan
INFECTION=./vendor/infection/infection/bin/infection

.PHONY: all

# Default target when just running 'make'
all: analyze test

vendor: composer.json composer.lock
	composer install

$(PHPUNIT): vendor
$(PHPA): vendor
$(PHPCS): vendor
$(PHPMD): vendor
$(PHPCBF): vendor
$(PHPSTAN): vendor
$(INFECTION): vendor


.PHONY: test test-unit test-infection

test: test-unit test-infection

test-unit: $(PHPUNIT) vendor
	$(PHPUNIT) --coverage-text

test-infection: $(INFECTION) vendor build/logs
	$(INFECTION) --threads=4 --min-covered-msi=50


.PHONY: analyze cs-fix cs-check phpstan validate messdetector

analyze: cs-check messdetector assumptions phpstan validate

cs-fix: $(PHPCBF)
	$(PHPCBF) app --standard=phpcs.ruleset.xml

cs-check: $(PHPCS)
	$(PHPCS) app --standard=phpcs.ruleset.xml

messdetector: $(PHPMD)
	$(PHPMD) app text phpmd.ruleset.xml

assumptions: $(PHPA)
	$(PHPA) app tests

phpstan: $(PHPSTAN)
	$(PHPSTAN) analyze app --level=3

validate:
	composer validate
