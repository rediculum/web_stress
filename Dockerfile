FROM debian:stable-slim
LABEL Description="Web Stress"

RUN apt update && \
    apt install -y stress curl nginx php-fpm && \
    mkdir -p /run/nginx && \
    mkdir -p /run/php

ADD www /www
ADD default.conf /etc/nginx/sites-enabled/default
ADD run.sh /run.sh

EXPOSE 80
HEALTHCHECK CMD curl -sf http://localhost/health || exit 1
CMD /run.sh
