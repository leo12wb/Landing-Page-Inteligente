# ─── Stage 1: Build Tailwind CSS ────────────────────────────────────────────
FROM node:20-alpine AS css-builder

WORKDIR /build

COPY package.json ./
RUN npm install --silent

COPY tailwind.config.js ./
COPY public/assets/css/input.css ./public/assets/css/input.css
COPY views/ ./views/
COPY app/  ./app/

RUN npm run build


# ─── Stage 2: PHP 8.2 + Apache ──────────────────────────────────────────────
FROM php:8.2-apache

# Instala dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
        unzip \
        git \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilita módulos Apache e suprime warning de ServerName
RUN a2enmod rewrite headers deflate \
    && (a2enmod brotli 2>/dev/null || true) \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Instala Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copia configuração do Apache
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Copia dependências primeiro para aproveitar cache do Docker
COPY composer.json ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# Copia o restante do projeto
COPY . .

# Copia o CSS compilado do stage anterior
COPY --from=css-builder /build/public/assets/css/app.css ./public/assets/css/app.css

# Garante permissões corretas no diretório de logs
RUN mkdir -p storage/logs \
    && chown -R www-data:www-data storage \
    && chmod -R 775 storage

EXPOSE 80
