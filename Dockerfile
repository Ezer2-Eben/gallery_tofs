# Utiliser PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les extensions nécessaires à Laravel et MySQL
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Activer mod_rewrite d’Apache
RUN a2enmod rewrite

# Copier le projet dans /var/www/html
COPY . /var/www/html

# Définir le dossier de travail
WORKDIR /var/www/html

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port 80
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
