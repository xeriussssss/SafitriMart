FROM php:8.2-apache

# Install system dependencies + PHP extensions
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        intl \
        zip \
        gd \
        pdo \
        pdo_mysql \
        mbstring \
        bcmath \
        opcache \
        xml \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Fix Apache MPM conflict
RUN a2dismod mpm_event mpm_worker 2>/dev/null; a2enmod mpm_prefork

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Apache config
RUN a2enmod rewrite
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["bash", "-c", "php artisan storage:link --force && php artisan migrate --force && php -S 0.0.0.0:80 -t public"]