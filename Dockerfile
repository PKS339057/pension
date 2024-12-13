# Используем официальный образ PHP с Apache
FROM php:7.4-apache

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install mysqli

# Копируем содержимое текущей директории в директорию /var/www/html в контейнере
COPY . /var/www/html/

# Устанавливаем права на директорию
RUN chown -R www-data:www-data /var/www/html

# Открываем порт 80
EXPOSE 80