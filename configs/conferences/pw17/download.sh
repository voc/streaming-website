#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://fahrplan.privacyweek.at/schedule.xml" -O /tmp/pw17-schedule.xml && mv /tmp/pw17-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/pw17/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
