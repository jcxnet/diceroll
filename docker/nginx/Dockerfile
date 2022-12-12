FROM nginx:latest

RUN rm /etc/nginx/conf.d/default.conf

COPY docker/nginx/conf/app.conf /etc/nginx/conf.d/app.conf
COPY docker/nginx/conf/nginx.conf /etc/nginx/nginx.conf

WORKDIR /app

COPY app/ app/