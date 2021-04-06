#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://entropia.de/GPN16:Fahrplan:XML?action=raw" -O /tmp/gpn16-schedule.xml && mv /tmp/gpn16-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/gpn16/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
