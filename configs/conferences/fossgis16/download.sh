#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://frab.fossgis-konferenz.de/de/2016/public/schedule.xml" -O /tmp/fossgis16-schedule.xml && mv /tmp/fossgis16-schedule.xml schedule.xml
rm -f /tmp/fossgis16-schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/fossgis16/index.json" -O /tmp/fossgis16-vod.json && mv /tmp/fossgis16-vod.json vod.json
rm -f /tmp/fossgis16-vod.json
