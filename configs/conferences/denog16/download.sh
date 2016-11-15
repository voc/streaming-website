#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://data.c3voc.de/schedule/denog16/schedule-darmstadtium.xml" -O /tmp/denog16-schedule.xml && mv /tmp/denog16-schedule.xml schedule.xml


# vod json
wget -q "http://live.dus.c3voc.de/relive/denog16/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
