FROM richarvey/nginx-php-fpm
ARG WWW_PATH
ARG DOMAIN_NAME
ENV WWW_PATH=$WWW_PATH
RUN apk update
RUN apk add ffmpeg
RUN mkdir -p $WWW_PATH
WORKDIR $WWW_PATH
ADD ./ ./
RUN mkdir -p uploads/playing
RUN chmod a+w uploads
RUN chmod a+w uploads/playing
#RUN envsubst '$MYSQL_HOST$MYSQL_ROOT_USER$MYSQL_ROOT_PASSWORD$MYSQL_DATABASE$DOMAIN_NAME' < docker/config/config.php > config/config.php
RUN chmod a+w config/config.php
RUN envsubst '$DOMAIN_NAME$WWW_PATH' < docker/nginx.config > /etc/nginx/sites-enabled/default.conf
RUN sed -i 's/libfdk_aac/aac/g' include/ffcontrol.php