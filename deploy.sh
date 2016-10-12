#!/bin/sh

find . -name "*.php" -print0 | xargs -0 -n1 php -l
if [ $? -ne 0 ]; then
	echo "not deploying b0rken code ;)"
	exit 1
fi

ssh voc@lb.dus.c3voc.de 'sudo sh' << EOT
cd /srv/nginx/streaming-website
git fetch origin
git reset --hard origin/master
chown -R voc:staff .
chown -R downloader configs
./clear_cache
EOT
