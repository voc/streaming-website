#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://jh.kohl.okfn.de/schedule-jh.xml" -O /tmp/jh18-ulm-schedule.xml && mv /tmp/jh18-ulm-schedule.xml schedule.xml

# relive
wget -q "//live.ber.c3voc.de/relive/jh/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
rm -f /tmp/jh18-ulm-schedule.xml
