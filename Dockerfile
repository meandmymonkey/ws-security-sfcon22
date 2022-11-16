FROM composer:2.4.1 AS composer

FROM php:8.1-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt update \
    && apt install -y unzip gnupg \
    && curl -SsL https://packages.httpie.io/deb/KEY.gpg | apt-key add - \
	&& curl -SsL -o /etc/apt/sources.list.d/httpie.list https://packages.httpie.io/deb/httpie.list \
	&& apt update \
	&& apt install -y httpie

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt install -y symfony-cli

RUN apt install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /srv/app

CMD ["/bin/bash", "-c", "symfony serve"]
