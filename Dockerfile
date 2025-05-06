# Utiliser une image PHP officielle avec Apache
FROM php:8.1-apache

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Activer le module Apache pour les fichiers .htaccess
RUN a2enmod rewrite

# Copier tous les fichiers du projet dans le répertoire Apache
COPY . /var/www/html/

# Exposer le port 80 pour l'accès HTTP
EXPOSE 80

# Démarrer Apache en arrière-plan
CMD ["apache2-foreground"]
