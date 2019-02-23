FROM nginx:1.13.3

RUN apt-get update && apt-get install -y --no-install-recommends vim htop procps

ADD ./nginx.conf /etc/nginx/nginx.conf

COPY ./default.conf /etc/nginx/conf.d/default.conf
