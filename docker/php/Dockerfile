FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    zlib1g-dev \
    nano \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    gnupg \
    build-essential \
    libssl-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev \
    zip

#In this place you can specify all the extensions you need.
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    gd \
    mbstring \
    zip
    
RUN docker-php-ext-configure gd --with-freetype --with-jpeg=/usr/include/ --enable-gd 
RUN docker-php-ext-install -j$(nproc) gd

RUN pecl install xdebug-3.1.6 && docker-php-ext-enable xdebug

#INSTALL LIBRERIA PARA EXPORTAR A PDF
RUN apt-get update && apt-get install -y     wget     fontconfig     libfreetype6     libxrender1     libxext6     xfonts-75dpi     xfonts-base
# RUN apt-get install -y xvfb openssl build-essential xorg 
# RUN wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6.1-2/wkhtmltox_0.12.6.1-2.bullseye_amd64.deb \
#     dpkg -i wkhtmltox_0.12.6.1-2.bullseye_amd64.deb

COPY --from=composer:2.0.9 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www