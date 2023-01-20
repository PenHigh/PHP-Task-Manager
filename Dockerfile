FROM php:8.1-apache

COPY ./src/ .

EXPOSE 80

CMD ["apache2-foreground"]
