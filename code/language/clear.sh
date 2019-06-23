#!/bin/bash

php artisan view:clear \
    && php artisan clear-compiled \
    && php artisan optimize \
    && php artisan config:cache \
    && php artisan route:cache
