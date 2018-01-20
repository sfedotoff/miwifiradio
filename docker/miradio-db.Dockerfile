FROM mysql
ADD ./db.sql /docker-entrypoint-initdb.d/miradio.sql