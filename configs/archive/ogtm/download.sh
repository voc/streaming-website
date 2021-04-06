#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://c3voc.de/share/schedules/ogtm17.xml" -O /tmp/ogtm17-schedule.xml && mv /tmp/ogtm17-schedule.xml schedule.xml

# relive
#wget -q "http://live.dus.c3voc.de/relive/jh-ulm-2017/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
#rm -f /tmp/vod.json
