#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://events.sublab.io/en/CC16/public/schedule.xml" -O /tmp/cryptocon16-schedule.xml && mv /tmp/cryptocon16-schedule.xml schedule.xml

wget -q "http://live.dus.c3voc.de/relive/cc16/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
