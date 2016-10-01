#!/bin/sh

# fahrplan
wget --no-check-certificate -q "geruempel.ddns.net/schedule_voc.xml" -O /tmp/vcfb2016-schedule.xml && mv /tmp/vcfb2016-schedule.xml schedule.xml
rm -f /tmp/qtcon16-schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/qtcon16/index.json" -O /tmp/qtcon16-vod.json && mv /tmp/qtcon16-vod.json vod.json
rm -f /tmp/qtcon16-vod.json
