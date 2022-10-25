FROM php:8.1-fpm as dev

WORKDIR /var/www/laradock

RUN mkdir /var/www/laradock -p

COPY ./ /var/www/laradock

WORKDIR /var/www/laradock

RUN apt-get update
RUN apt-get install zip wget git zlib1g-dev -y
RUN docker-php-ext-install pdo_mysql

# Composer
RUN wget https://getcomposer.org/composer.phar -O ./composer
RUN chmod +x composer && mv composer /usr/local/bin/composer
RUN composer install


FROM php:8.1-apache as production

RUN apt-get update && apt-get install -y \
    		libmcrypt-dev \
            zip 
RUN docker-php-ext-install pdo_mysql 

# Add the user UID:1000, GID:1000, home at /app
RUN groupadd -r app -g 1000 && useradd -u 1000 -r -g app -m -d /app -s /sbin/nologin -c "App user" app && \
    chmod 755 /var/www/html

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

#upload
RUN echo "file_uploads = On\n" \
         "memory_limit = 500M\n" \
         "upload_max_filesize = 500M\n" \
         "post_max_size = 500M\n" \
         "max_execution_time = 600\n" \
         > /usr/local/etc/php/conf.d/uploads.ini

USER app

WORKDIR /var/www/html

USER root

COPY default.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./ /var/www/html

RUN chmod 0777 /var/www/html/storage -R
RUN chmod 0777 /var/www/html/bootstrap/cache -R

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

EXPOSE 80

