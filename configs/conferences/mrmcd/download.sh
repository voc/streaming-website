#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://talks.mrmcd.net/2024/schedule/export/schedule.xml" -O /tmp/mrmcd24-schedule.xml && mv /tmp/mrmcd24-schedule.xml schedule.xml
rm -f /tmp/mrmcd24-schedule.xml

# relive
#wget -q "http://live.dus.c3voc.de/relive/emf2016/index.json" -O /tmp/emf2016-vod.json && mv /tmp/emf2016-vod.json vod.json
#rm -f /tmp/emf2016-vod.json
