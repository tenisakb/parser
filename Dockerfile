FROM php:7.1-apache 
RUN docker-php-ext-install mysqli
RUN apt-get update
RUN apt-get install libldap2-dev
RUN apt-get install libcurl3-dev
RUN apt-get install -y zip
RUN apt-get --yes install libxml2-dev
RUN docker-php-ext-install ldap
RUN docker-php-ext-install curl
RUN docker-php-ext-install soap
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install intl
