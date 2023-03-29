FROM docker.io/bitnami/laravel:8


#RUN apt-get update && apt-get install -y \
#    cron \ 
#    nano

RUN mkdir -p /app
WORKDIR /app

COPY ./ /app

RUN composer update

RUN composer install

RUN echo " \
\\n\
extension      = pgsql\\n\
extension      = pdo_pgsql\\n\ " >> /opt/bitnami/php/etc/php.ini

RUN  /opt/bitnami/scripts/laravel/postunpack.sh
RUN /opt/bitnami/scripts/php/postunpack.sh
ENV BITNAMI_APP_NAME=laravel BITNAMI_IMAGE_VERSION=8.6.11-debian-10-r15 NODE_PATH=/opt/bitnami/node/lib/node_modules PATH=/opt/bitnami/python/bin:/opt/bitnami/php/bin:/opt/bitnami/php/sbin:/opt/bitnami/node/bin:/opt/bitnami/common/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin PHP_ENABLE_OPCACHE=0

#COPY ./run.sh /opt/bitnami/scripts/laravel/run.sh
RUN php artisan optimize
#RUN crontab -l | { cat; echo "0 1 * * * /opt/bitnami/php/bin/php /app/artisan schedule:run"; } | crontab
#RUN crontab -l | { cat; echo "0 13 * * * /opt/bitnami/php/bin/php /app/artisan schedule:run"; } | crontab
#RUN crontab -l
#RUN service cron start
RUN php artisan config:cache
#RUN php artisan migrate


ENTRYPOINT ["/opt/bitnami/scripts/laravel/entrypoint.sh"]
CMD ["/opt/bitnami/scripts/laravel/run.sh"]
#CMD php -q -S 0.0.0.0:4100 public/index.php
