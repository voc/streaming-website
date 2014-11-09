#!/bin/sh
echo "building scss"
scss assets/css/src/lustige-styles.scss assets/css/lustige-styles.css

echo "removing old build"
rm -rf build

echo "spidering page"
mkdir -p build
wget \
	--no-verbose \
	--no-clobber \
	--no-host-directories \
	--cut-dirs=3 \
	--directory-prefix=build \
	--user-agent=StaticBuildScript \
	--recursive \
	--no-parent \
	--page-requisites \
	--convert-links \
	http://localhost/~peter/voc-frontends/31c3/
