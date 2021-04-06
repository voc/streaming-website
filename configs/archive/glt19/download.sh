#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://pretalx.linuxtage.at/glt19/schedule/export/schedule.xml" -O /tmp/glt19-schedule.xml && mv /tmp/glt-19-schedule.xml schedule.xml

# relive
#wget -q "http://live.dus.c3voc.de/relive/gpn16/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
#rm -f /tmp/vod.json
