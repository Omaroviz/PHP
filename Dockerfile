# Берём официальный образ PHP с Apache
FROM php:8.2-apache

# Устанавливаем расширения для MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Включаем mod_rewrite (для ЧПУ)
RUN a2enmod rewrite

# Копируем твой код в папку веб-сервера внутри контейнера
COPY . /var/www/html/

# Даём права (чтобы Apache мог читать файлы)
RUN chown -R www-data:www-data /var/www/html
