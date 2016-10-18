#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://datenspuren.de/2016/fahrplan/schedule.xml" -O /tmp/DS2016-schedule.xml && mv /tmp/DS2016-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/DS2016/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
