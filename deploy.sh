#!/bin/bash

for cmd in find xargs php git; do
	command -v $cmd >/dev/null 2>&1 || { echo >&2 "I require $cmd but it's not installed.  Aborting."; exit 1; }
done


find . -name "*.php" -print0 | xargs -0 -n1 php -l
if [ $? -ne 0 ]; then
	echo "not deploying b0rken code ;)"
	exit 1
fi

if [ `git rev-parse --verify origin/$DEPLOY_BRANCH` != `git rev-parse --verify $DEPLOY_BRANCH` ]; then
	echo "You have commits on the master branch not pushed to origin yet. They would not be deployed."
	echo "do you still which to deploy what's already in the repo? then type yes"
	read -p "" input
	if [ "x$input" != "xyes" ]; then
		exit 2
	fi
fi

if ! (git diff --exit-code >/dev/null || git diff --cached --exit-code >/dev/null); then
	echo "You have uncomitted changes. They would not be deployed."
	echo "do you still which to deploy what's already in the repo? then type yes"
	read -p "" input
	if [ "x$input" != "xyes" ]; then
		exit 2
	fi
fi

ssh -A voc@lb.dus.c3voc.de 'sudo sh' << EOT
cd /srv/nginx/streaming-website
git fetch origin
git reset --hard origin/master
chown -R voc:staff .
chown -R downloader configs
./clear_cache
EOT
