FROM php:8.1-apache

EXPOSE 80

RUN docker-php-ext-install mysqli

RUN a2enmod rewrite

COPY ./src/ .

CMD ["apache2-foreground" ]
