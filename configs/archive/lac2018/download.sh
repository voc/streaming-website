#!/bin/sh

# fahrplan
#wget --no-check-certificate -q "https://.../schedule.xml" -O /tmp/schedule.xml && mv /tmp/schedule.xml schedule.xml
#rm -f /tmp/schedule.xml

# vod json
wget -q "http://live.dus.c3voc.de/relive/lac2018/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
