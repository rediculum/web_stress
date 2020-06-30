FROM debian:stable-slim
LABEL Description="Web Stress"

RUN apt update && \
    apt install -y stress curl nginx php-fpm && \
    mkdir -p /run/nginx && \
    mkdir -p /run/php

ADD www /www
ADD nginx.conf /etc/nginx/nginx.conf
ADD php-fpm.conf /etc/php/7.3/fpm/php-fpm.conf
ADD run.sh /run.sh

EXPOSE 80
HEALTHCHECK CMD curl -sf http://localhost/health || exit 1
CMD /run.sh
