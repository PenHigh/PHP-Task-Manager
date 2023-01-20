FROM php:7.4-apache

COPY ./src/ .

EXPOSE 80

CMD ["apache2-foreground" ]
