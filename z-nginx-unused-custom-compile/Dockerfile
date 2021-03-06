# its what the nginx peeps are using for their official one
FROM debian:jessie

# https://github.com/docker/docker/issues/8631
RUN echo "export TERM=xterm" >> /etc/bash.bashrc

# install NGINX build prereqs
# install NGINX build (incl curl for downloading)
RUN apt-get update && \
    apt-get install -y \
        bash \
        build-essential \
        curl \
        libpcre3 libpcre3-dev \
        libssl1.0.0 libssl-dev \
        openssl \
        zlib1g zlib1g-dev && \
    apt-get clean && \
    rm -r /var/lib/apt/lists/*;


ENV NGX_SRC_VERSION 1.11.8
ENV NGX_CACHEPURGE_VERSION 2.3
ENV NGX_MOREHEADERS_VERISON 0.32

ENV NGX_SRC_URL http://nginx.org/download/nginx-$NGX_SRC_VERSION.tar.gz
ENV NGX_CACHEPURGE_URL https://github.com/FRiCKLE/ngx_cache_purge/archive/$NGX_CACHEPURGE_VERSION.tar.gz
ENV NGX_MOREHEADERS_URL https://github.com/openresty/headers-more-nginx-module/archive/v$NGX_MOREHEADERS_VERISON.tar.gz

ENV NGX_SRC_DEST /tmp/ngxsrc
ENV NGX_CACHEPURGE_DEST $NGX_SRC_DEST/ngxcachepurge
ENV NGX_MOREHEADERS_DEST $NGX_SRC_DEST/ngxmoreheaders


RUN mkdir $NGX_SRC_DEST $NGX_CACHEPURGE_DEST $NGX_MOREHEADERS_DEST && \
	curl -sSL $NGX_SRC_URL | \
	tar -xvz  --strip-components 1 -C $NGX_SRC_DEST && \
	curl -sSL $NGX_CACHEPURGE_URL | \
	tar -xvz  --strip-components 1 -C $NGX_CACHEPURGE_DEST && \
	curl -sSL $NGX_MOREHEADERS_URL | \
	tar -xvz  --strip-components 1 -C $NGX_MOREHEADERS_DEST

WORKDIR $NGX_SRC_DEST
RUN ./configure \
	--with-debug \
	--with-http_ssl_module \
	--add-module=$NGX_CACHEPURGE_DEST \
	--add-module=$NGX_MOREHEADERS_DEST \
	--sbin-path=/usr/sbin/nginx \
	--conf-path=/etc/nginx/nginx.conf \
	--pid-path=/var/run/nginx.pid \
	--error-log-path=/var/log/nginx/error.log \
	--http-log-path=/var/log/nginx/access.log \
	--user=www-data && \
	make && make install

RUN rm -rf /tmp/*


# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log

# install envtpl (for building conf files) and other packages we like
RUN apt-get update && \
    apt-get install -y \
        python3-pip \
        sudo \
        vim && \
    apt-get clean && \
    rm -r /var/lib/apt/lists/* && \
    pip3 install envtpl;

WORKDIR /etc/nginx

# set container to nyc time...
RUN echo "America/New_York" > /etc/timezone

COPY server-defaults.conf include/server-defaults.conf


ENV NGX_ROOT /var/www/html
ENV NGX_CLIENT_MAX_BODY_SIZE 10m
ENV NGX_GZIP_ON_OFF off
ENV NGX_ERROR_LOG_LEVEL warn
ENV NGX_SENDFILE on

# standard listen ports
EXPOSE 80 443

# our default conf
COPY ./nginx.conf.ngxtpl /etc/nginx/nginx.conf.ngxtpl

COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["nginx", "-g", "daemon off;"]
