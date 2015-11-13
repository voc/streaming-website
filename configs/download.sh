#!/bin/sh

# conferences
wd=`pwd`
for d in conferences/*; do
	if [ -x $d/download.sh ]; then
		cd $d
		./download.sh
		cd $wd
	fi
done

# eventkalender upcoming
wget -q --no-check-certificate "https://c3voc.de/eventkalender/events.json?filter=upcoming&streaming=yes" -O /tmp/upcoming.json && mv /tmp/upcoming.json upcoming.json
