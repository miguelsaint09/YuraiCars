web: cp .env.example .env && \
    composer install --no-dev --optimize-autoloader && \
    npm ci && \
    npm run build && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan storage:link && \
    php -S 0.0.0.0:$PORT -t public/