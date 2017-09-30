#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://data.c3voc.de/jh17/schedule-jh17-ulm.xml" -O /tmp/jh17-ulm-schedule.xml && mv /tmp/jh17-ulm-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/jh-ulm-2017/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
