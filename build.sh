#!/bin/sh

LOCAL_SERVER='http://localhost/~peter/voc-frontends/31c3'

echo "building scss"
scss assets/css/src/lustige-styles.scss assets/css/lustige-styles.css

echo "removing old build"
rm -rf build

echo "spidering page"
mkdir -p build
wget \
	--no-verbose \
	--no-host-directories \
	--cut-dirs=3 \
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
