#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://frab.fossgis-konferenz.de/en/foss4g-2016/public/schedule.xml" -O /tmp/foss4g-2016-schedule.xml && mv /tmp/foss4g-2016-schedule.xml schedule.xml
rm -f /tmp/foss4g-2016-schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/foss4g-2016/index.json" -O /tmp/foss4g-2016-vod.json && mv /tmp/foss4g-2016-vod.json vod.json
rm -f /tmp/foss4g-2016-vod.json
