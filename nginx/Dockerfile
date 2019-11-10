FROM alpine:3.8

MAINTAINER Vincent Composieux <vincent.composieux@gmail.com>

RUN apk add --update --no-cache nginx

COPY nginx.conf /etc/nginx/

RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
        ln -sf /dev/stderr /var/log/nginx/error.log

RUN adduser -D -g '' -G www-data www-data

CMD ["nginx"]
