#!/bin/sh

php_bin=""
port=8000

for try_bin in php8 php7 php
do
	php_bin=$(command -v $try_bin)
	if [ -n "$php_bin" ]
	then
		break
	fi
done

echo "Using PHP: $php_bin"

if [ -n "$1" ]
then
	port=$1
fi

# check if we should update schedules, upcoming, etc.
if [ -z "$(find "configs/upcoming.json" -newermt "8 hours ago")" ]; then
	echo "Updating schedules…\n"
	./download.sh
	echo
fi

$php_bin -S localhost:$port -d short_open_tag=true $2 index.php
