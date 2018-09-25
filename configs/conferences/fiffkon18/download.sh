#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://data.testi.ber.c3voc.de/schedule/fiffkon16/schedule-Hoersaal.xml" -O /tmp/fiffkon16-schedule.xml && mv /tmp/fiffkon-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/fiffkon/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
