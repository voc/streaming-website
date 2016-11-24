#!/bin/bash

command -v find >/dev/null 2>&1 || { echo >&2 "I require find but it's not installed.  Aborting."; exit 1; }
command -v xargs >/dev/null 2>&1 || { echo >&2 "I require xargs but it's not installed.  Aborting."; exit 1; }
command -v php >/dev/null 2>&1 || { echo >&2 "I require php but it's not installed.  Aborting."; exit 1; }

find . -name "*.php" -print0 | xargs -0 -n1 php -l
if [ $? -ne 0 ]; then
	echo "not deploying b0rken code ;)"
	exit 1
fi

if [ `git rev-parse --verify origin/master` != `git rev-parse --verify master` ]; then
	echo "You have commits on the master branch not pushed to origin yet. They would not be deployed. aborting"
	exit 2
fi

if ! (git diff --exit-code >/dev/null || git diff --cached --exit-code >/dev/null); then
	echo "You have uncomitted changes. They would not be deployed. aborting"
	exit 2
fi

ssh -A voc@lb.dus.c3voc.de 'sudo sh' << EOT
cd /srv/nginx/streaming-website
git fetch origin
git reset --hard origin/master
chown -R voc:staff .
chown -R downloader configs
chmod +x configs/download.sh
chmod +x configs/conferences/*/download.sh
./clear_cache
EOT
