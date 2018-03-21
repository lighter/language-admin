FROM redis:4
ENV REDIS_PASSWORD a9sjkf9jskf03kYYJ
COPY ./redis.conf /usr/local/etc/redis/redis.conf
CMD ["sh", "-c", "exec redis-server  \/usr\/local\/etc\/redis\/redis.conf --requirepass \"$REDIS_PASSWORD\""]