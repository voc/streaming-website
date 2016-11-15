#!/bin/sh

command -v find >/dev/null 2>&1 || { echo >&2 "I require find but it's not installed.  Aborting."; exit 1; }
command -v xargs >/dev/null 2>&1 || { echo >&2 "I require xargs but it's not installed.  Aborting."; exit 1; }
command -v php >/dev/null 2>&1 || { echo >&2 "I require php but it's not installed.  Aborting."; exit 1; }

find . -name "*.php" -print0 | xargs -0 -n1 php -l
if [ $? -ne 0 ]; then
	echo "not deploying b0rken code ;)"
	exit 1
fi

ssh -A voc@lb.dus.c3voc.de 'sudo sh' << EOT
cd /srv/nginx/streaming-website
git fetch origin
git reset --hard origin/master
chown -R voc:staff .
chown -R downloader configs
./clear_cache
EOT
