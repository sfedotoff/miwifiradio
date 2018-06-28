FROM mysql:5.7.22
ADD ./db.sql /docker-entrypoint-initdb.d/miradio.sql