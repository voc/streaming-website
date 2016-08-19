#!/bin/sh
port=8000
if [ -n "$1" ]; then port=$1; fi
php -S localhost:$port -d short_open_tag=true index.php
