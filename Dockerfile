FROM php:8.1-apache

COPY ./src/ .

EXPOSE 80

RUN docker-php-ext-install mysqli

RUN a2enmod rewrite

CMD ["apache2-foreground" ]
