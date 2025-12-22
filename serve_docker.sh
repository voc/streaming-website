#!/bin/sh
host=localhost
port=8000
docker_image="php:8.4-apache"

if [ -n "$2" ]
then
    host=$1
    port=$2
elif [ -n "$1" ]
then
    port=$1
fi

# check if we should update schedules, upcoming, etc.
if [ -z "$(find "configs/upcoming.json" -newermt "8 hours ago")" ]; then
    echo "Updating schedules…"
    docker run --rm -v "$PWD":/var/www/html -w /var/www/html $docker_image bash -c php -d short_open_tag=true index.php download
    #chown $(id -u):$(id -g) configs/upcoming.json
    echo
fi

# stop and remove any existing container named streaming-website
docker stop streaming-website 2>/dev/null
docker rm streaming-website 2>/dev/null

echo "Starting server at http://$host:$port"
docker run --rm --name streaming-website -p $port:80 -v "$PWD":/var/www/html -w /var/www/html $docker_image /bin/bash -c 'a2enmod rewrite; apache2-foreground'
