#FROM php:8.2-fpm
FROM php:8.2-fpm-bullseye

ARG UID
EXPOSE $UID
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN adduser -u ${UID} --disabled-password --gecos "" appuser
RUN mkdir /home/appuser/.ssh
RUN chown -R appuser:appuser /home/appuser/
RUN echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config
RUN echo "export COLUMNS=300" >> /home/appuser/.bashrc
RUN echo "alias sf=/appdata/www/bin/console" >> /home/appuser/.bashrc

COPY ./php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
    && curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && apt-get install -y git acl openssl openssh-client wget zip vim libssh-dev \
    && apt-get install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip gd soap bcmath sockets \
    && pecl install xdebug \
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache xdebug 
    

RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update
##RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet && mv composer.phar chmod +x /usr/local/bin/composer
RUN export COMPOSER_ALLOW_SUPERUSER=1
#RUN source ~/.bashrc



#RUN wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O php-cs-fixer
RUN wget https://get.symfony.com/cli/installer -O - | bash 
#&& mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
#&& mv /usr/bin/symfony /usr/bin/symfony
#RUN chmod a+x php-cs-fixer
#RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer
#RUN git config --global user.email "ubinetfone@gmail.com" \
#  && git config --global user.name "Ricardo Miguel"

RUN mkdir -p /appdata/www


WORKDIR /appdata/www

#RUN cd /appdata/www && /root/.symfony5/bin/symfony new --webapp my_project
##RUN mv my_project/{*,.[!.]*} .
