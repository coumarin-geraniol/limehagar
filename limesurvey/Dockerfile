# Use PHP 8.0 with Apache as a base image
FROM php:8.0-apache

# Install necessary packages
RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y libzip-dev zip unzip \
    && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && apt-get install -y libldap2-dev \
    && apt-get install -y libc-client-dev libkrb5-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install ldap \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && docker-php-ext-enable mysqli

# Copy LimeSurvey directory and config file
COPY ./limesurvey /var/www/html/limesurvey
COPY ./limesurvey.conf /etc/apache2/sites-available/

# Set proper permissions and enable site
RUN chown -R www-data:www-data /var/www/html/limesurvey && \
    chmod -R 755 /var/www/html/limesurvey && \
    a2ensite limesurvey && \
    a2dissite 000-default.conf && \
    a2enmod rewrite && \
    service apache2 restart

EXPOSE 80
