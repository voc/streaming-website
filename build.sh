#!/bin/sh

LOCAL_SERVER='http://localhost/streaming-website'

echo "building less"
rm -f assets/css/main.css
lessc assets/css/main.less assets/css/main.css

echo "removing old build"
rm -rf build

echo "spidering page"
mkdir -p build
wget \
	--no-verbose \
	--no-host-directories \
	--cut-dirs=1 \
	--directory-prefix=build \
	--user-agent=StaticBuildScript \
	--recursive \
	--no-parent \
	--page-requisites \
	$LOCAL_SERVER/ \
	$LOCAL_SERVER/404.html \
	$LOCAL_SERVER/program.json

echo "setting <base />-tag"
find build -name "*.html" -print0 | xargs -0 -exec sed -i 's~<base href="[^"]*" />~<base href="/" />~g';

echo "inserting hidden compiletime marker"
find build -name "*.html" -print0 | xargs -0 -exec sed -i "s~<!DOCTYPE html>~<!DOCTYPE html>\n<!-- static published at `date` on `uname -n` -->~g";


echo "copying .htaccess"
cp build.htaccess build/.htaccess
