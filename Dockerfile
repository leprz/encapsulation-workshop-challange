FROM php:8.4-cli

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json ./
RUN composer install --no-interaction --optimize-autoloader

COPY . .

CMD ["php", "main.php"]
