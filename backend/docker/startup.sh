#!/usr/bin/env bash

dockerize -wait tcp://${DB_HOST}:${DB_PORT} -timeout 120s \
    php vendor/bin/doctrine orm:generate-proxies && \
    php vendor/bin/doctrine orm:schema-tool:update --force # Just for test. Not for a production environment
