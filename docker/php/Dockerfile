FROM fsilva/php:7.2

RUN echo "xdebug.remote_enable=on\nxdebug.remote_connect_back=off\nxdebug.remote_host=\"host.docker.internal\"" > /usr/local/etc/php/conf.d/xdebug.ini && \
    mkdir -p /usr/local/etc/php/xdebug.d && \
    mv /usr/local/etc/php/conf.d/*xdebug.ini /usr/local/etc/php/xdebug.d/