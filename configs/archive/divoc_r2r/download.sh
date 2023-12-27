#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://data.c3voc.de/divoc/everything.schedule.xml" -O /tmp/divoc_r2r-schedule.xml && mv /tmp/divoc_r2r-schedule.xml schedule.xml

# relive
#wget -q "http://live.dus.c3voc.de/relive/gpn16/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
#rm -f /tmp/vod.json
