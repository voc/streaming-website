#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://events.opensuse.org/conference/oSC16/schedule.xml" -O /tmp/osc16-schedule.xml && mv /tmp/osc16-schedule.xml schedule.xml
rm -f /tmp/osc16-schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/osc16/index.json" -O /tmp/osc16-vod.json && mv /tmp/osc16-vod.json vod.json
rm -f /tmp/osc16-vod.json
