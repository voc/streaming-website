#!/bin/bash

for cmd in find xargs php git; do
	command -v $cmd >/dev/null 2>&1 || { echo >&2 "I require $cmd but it's not installed.  Aborting."; exit 1; }
done


find . -name "*.php" -print0 | xargs -0 -n1 php -l
if [ $? -ne 0 ]; then
	echo "not deploying b0rken code ;)"
	exit 1
fi

echo ""
DEPLOY_BRANCH=`git rev-parse --abbrev-ref HEAD`

if [ `git rev-parse --verify origin/$DEPLOY_BRANCH` != `git rev-parse --verify $DEPLOY_BRANCH` ] && [ `git rev-parse --verify origin/staging` != `git rev-parse --verify $DEPLOY_BRANCH` ]; then
	echo "You have commits on the $DEPLOY_BRANCH branch not pushed to origin yet. They would not be deployed."
	echo "do you still which to deploy what's already in the repo? then type yes"
	read -p "" input
	if [ "x$input" != "xyes" ]; then
		exit 2
	fi
	echo ""
fi

if ! (git diff --exit-code >/dev/null && git diff --cached --exit-code >/dev/null); then
	echo "You have uncomitted changes. They would not be deployed."
	echo "do you still which to deploy what's already in the repo? then type yes"
	read -p "" input
	if [ "x$input" != "xyes" ]; then
		exit 2
	fi
	echo ""
fi

if [ "x$DEPLOY_BRANCH" != "xmaster" ] && [ "x$DEPLOY_BRANCH" != "xstaging" ]; then
	echo "You're currently on branch $DEPLOY_BRANCH."
	echo "Are you sure you want to deploy that branch (and not master)? then type yes"
	read -p "" input
	if [ "x$input" != "xyes" ]; then
		exit 2
	fi
	echo ""
fi

for host in streaming.test.c3voc.de; do
	echo "deploying to $host"
	ssh -A voc@$host 'sudo sh' << EOT
cd /srv/nginx/streaming-website

echo "updating code"
git fetch origin
git reset --hard HEAD
git checkout $DEPLOY_BRANCH
git reset --hard origin/$DEPLOY_BRANCH

echo "fixing permissions"
chown -R voc:staff .
chown -R downloader configs

echo "re-downloading schedules"
sudo -udownloader php index.php download

echo "clearing cache"
./clear_cache
EOT
	echo "deploying to $host done"
done