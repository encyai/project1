# Temel imaj olarak PHP 8.1 kullan
FROM php:8.1-apache

# Proje dosyalarını kopyala
COPY . .

# Gerekli PHP uzantılarını yükle
RUN docker-php-ext-install pdo pdo_mysql

