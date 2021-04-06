#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://2016.mrmcd.net/fahrplan/schedule.xml" -O /tmp/mrmcd16-schedule.xml && mv /tmp/mrmcd16-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/mrmcd16/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
