FROM php:8.3-apache

# Composer autorisé à tourner en root dans le conteneur (supprime un avertissement)
ENV COMPOSER_ALLOW_SUPERUSER=1

# Extensions PHP requises par Symfony / Doctrine
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql intl zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Apache : mod_rewrite (routes Symfony) + nom de serveur (supprime un avertissement)
RUN a2enmod rewrite \
    && echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

# DocumentRoot pointé sur public/ comme l'exige Symfony
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
