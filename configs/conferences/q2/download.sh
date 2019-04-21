#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://cfp.privacyweek.at/pw18/schedule/export/schedule.xml" -O /tmp/pw18-schedule.xml && mv /tmp/pw18-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/pw18/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
