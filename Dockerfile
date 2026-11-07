FROM php:8.2-apache

# Установка необходимых расширений PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Включение mod_rewrite для Apache
RUN a2enmod rewrite

# Копирование файлов сайта
COPY . /var/www/html/

# Установка прав на директорию upload
RUN chown -R www-data:www-data /var/www/html/upload && \
    chmod -R 755 /var/www/html/upload

# Установка размера загружаемых файлов
RUN echo "upload_max_filesize = 10M" > /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/uploads.ini

EXPOSE 80
