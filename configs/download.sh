#!/bin/bash

# conferences
owd="$(pwd)"
cd "${0%/*}"
wd="$(pwd)"
for d in conferences/*; do
	if [ -x $d/download.sh ]; then
		echo "$d"
		cd "$d"
		./download.sh
		cd "$wd"
	fi
done
cd "$wd"

# eventkalender upcoming
echo "eventkalender"
wget -q --no-check-certificate "https://c3voc.de/eventkalender/events.json?filter=upcoming&streaming=yes" -O /tmp/upcoming.json && mv /tmp/upcoming.json upcoming.json

cd "$owd"
