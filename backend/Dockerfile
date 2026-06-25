FROM ubuntu:22.04
LABEL maintainer="Ahmad Ullah Mukhlis"
WORKDIR /var/www

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

# Setup timezone and update base system
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && apt-get -y update \
    && apt-get install -y software-properties-common curl lsb-release gnupg2

# Add the repository for newer PHP versions (Required for PHP 8.2+ on Ubuntu)
RUN add-apt-repository ppa:ondrej/php -y && apt-get -y update

# Install PHP 8.2 core components and modules
RUN apt-get install -y \
    php8.2-fpm \
    php8.2-cli \
    php8.2-common \
    php8.2-mysql \
    php8.2-zip \
    php8.2-gd \
    php8.2-mbstring \
    php8.2-curl \
    php8.2-xml \
    php8.2-bcmath \
    php8.2-dev \
    php-pear \
    supervisor \
    mysql-client \
    unixodbc-dev

# Setup Microsoft SQL Server Drivers (MSODBC)
RUN curl https://microsoft.com | tee /etc/apt/trusted.gpg.d/microsoft.asc \
    && curl https://microsoft.com(lsb_release -rs)/prod.list | tee /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 \
    && echo 'export PATH="$PATH:/opt/mssql-tools18/bin"' >> ~/.bashrc

# Set PECL configuration pointing to the updated PHP 8.2 ini path
RUN pecl config-set php_ini /etc/php/8.2/fpm/php.ini

# Install Composer globally
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# Handle Composer package installation
RUN composer clear-cache
COPY ./composer.json .

# 🟢 FIX: Placed --no-audit as a global flag and added --no-security-blocking
RUN composer --no-audit install --no-interaction --no-plugins --no-scripts --no-security-blocking --ignore-platform-req=ext-zip --ignore-platform-req=ext-sockets

# Copy remaining code and fix application runtime permissions
COPY . .
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# System service configuration entries
COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /usr/local/bin/start-container

EXPOSE 6001
EXPOSE 80
ENTRYPOINT ["start-container"]
