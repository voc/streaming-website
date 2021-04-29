#!/bin/sh

php_bin=""
port=8000

for try_bin in php7 php
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

$php_bin -S localhost:$port -d short_open_tag=true index.php
