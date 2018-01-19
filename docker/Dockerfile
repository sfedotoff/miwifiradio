FROM richarvey/nginx-php-fpm
RUN apk update
RUN apk add ffmpeg
RUN mkdir -p /zdata/www/
WORKDIR /zdata/www/
RUN git clone https://github.com/andr68rus/miwifiradio.git
WORKDIR miwifiradio
RUN mkdir -p uploads/playing
RUN chmod a+w uploads
RUN chmod a+w uploads/playing

#RUN ls /mnt/sda1/var/lib/docker/tmp/
ADD ../../../../../../../d/work/miwifiradio/docker/options options
RUN envsubst < options/options.php
# replace env variables in options.php
# make options writable
# put nginx server config
# replace env variables in nginx server config
# change frn_aac to aac