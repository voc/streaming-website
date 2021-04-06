#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://pretalx.entropia.de/gpn19/schedule/export/schedule.xml" -O /tmp/gpn19-schedule.xml && mv /tmp/gpn19-schedule.xml schedule.xml
rm -f /tmp/gpn19-schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/ogpn19/index.json" -O /tmp/gpn19-vod.json && mv /tmp/gpn19-vod.json vod.json
rm -f /tmp/gpn19-vod.json
