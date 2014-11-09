#!/bin/sh
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
	http://localhost/~peter/voc-frontends/31c3/ \
	http://localhost/~peter/voc-frontends/31c3/404.html

echo "setting <base />-tag"
find build -name "*.html" -print0 | xargs -0 -exec sed -i 's~<base href="[^"]*" />~<base href="/" />~g';

echo "inserting hidden compiletime marker"
find build -name "*.html" -print0 | xargs -0 -exec sed -i "s~<!DOCTYPE html>~<!DOCTYPE html>\n<!-- static published at `date` on `uname -n` -->~g";


echo "copying .htaccess"
cp build.htaccess build/.htaccess
