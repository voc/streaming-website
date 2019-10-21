#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://cfp.privacyweek.at/pw19/schedule/export/schedule.xml" -O /tmp/pw19-schedule.xml && mv /tmp/pw19-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/pw19/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
