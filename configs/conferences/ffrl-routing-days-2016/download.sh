#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://mlsrv.de/public/routingdays16-schedule/schedule.xml" -O /tmp/schedule.xml && mv /tmp/schedule.xml schedule.xml
rm -f /tmp/schedule.xml /tmp/schedule.json

# vod json
wget -q "http://live.dus.c3voc.de/relive/ffrl-routing-days/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
