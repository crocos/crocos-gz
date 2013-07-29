# Makefile

# general
GZ_SRC_DIR          = src
GZ_WEB_DIR          = web
GZ_LOG_DIR          = log
GZ_CSS_DIR          = $(GZ_WEB_DIR)/stylesheets
GZ_LESS_DIR         = src/less

# less
GZ_LESS_FILE        = $(GZ_LESS_DIR)/gz.less
GZ_CSS_FILE         = $(GZ_CSS_DIR)/gz.css

# data dir
GZ_DATA_DIR         = web/data

# data dir
GZ_TWB_SRC_DIR      = vendor/twitter-bootstrap
GZ_TWB_DIST_DIR     = $(GZ_WEB_DIR)/twitter-bootstrap

# gzclient.app
GZCLIENT_DIR        = src
GZCLIENT_APP        = gzclient.app # relative
GZCLIENT_SCRIPT     = $(GZCLIENT_APP)/Contents/Resources/script
GZCLIENT_DIST       = $(GZ_WEB_DIR)/gzclient.zip

LESSC               = lessc
LESS_BUILD_OPT      =
LESS_BUILD_OPT_MIN  = -x

.SUFFIXES: .less .css .js

app:
	php bin/generate-client-app.php
	cd $(GZCLIENT_DIR); zip -r ../$(GZCLIENT_DIST) $(GZCLIENT_APP)

css: $(GZ_CSS_FILE)
$(GZ_CSS_FILE): $(GZ_LESS_FILE)
	$(LESSC) $(LESS_BUILD_OPT) $(GZ_LESS_FILE) $@
	$(LESSC) $(LESS_BUILD_OPT_MIN) $(GZ_LESS_FILE) $*.min.css

composer-download:
	test -f composer.phar || curl -sS https://getcomposer.org/installer | php

composer-install: composer-download
	php composer.phar install

composer-update: composer-download
	php composer.phar update

bootstrap:
	cd $(GZ_TWB_SRC_DIR) ;\
	npm install ;\
	grunt dist
	cp -a $(GZ_TWB_SRC_DIR)/dist/* $(GZ_TWB_DIST_DIR)

submodule-update:
	git submodule update --init

install: submodule-update composer-install
	chmod 777 $(GZ_DATA_DIR)
	chmod 777 $(GZ_LOG_DIR)

clean:
	rm -r web/data/*

.PYONY: install app
