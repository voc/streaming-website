#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://schedule.battlemesh.org/schedule.xml" -O /tmp/wbm10-schedule.xml && mv /tmp/wbm10-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/wbm10/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
