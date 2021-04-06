#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://programm.froscon.de/2017/schedule.xml" -O /tmp/froscon2017-schedule.xml && mv /tmp/froscon2017-schedule.xml schedule.xml
rm -f /tmp/froscon2017-schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/froscon16/index.json" -O /tmp/froscon2017-vod.json && mv /tmp/froscon2017-vod.json vod.json
rm -f /tmp/froscon2017-vod.json
