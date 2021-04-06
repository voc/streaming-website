#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://jh.kohl.okfn.de/schedule-jh19-ulm.xml" -O /tmp/jh19-ulm-schedule.xml && mv /tmp/jh19-ulm-schedule.xml schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/jh-ulm-2019/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
