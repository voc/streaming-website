#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://data.c3voc.de/schedule/jh16/schedule-berlin.xml" -O /tmp/jh16-berlin-schedule.xml && mv /tmp/jh16-berlin-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/jh-berlin-2016/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
