#!/bin/sh

# fahrplan original
wget --no-check-certificate -q "https://events.ccc.de/congress/2015/Fahrplan/schedule.xml" -O /tmp/schedule.xml && mv /tmp/schedule.xml schedule.xml
wget --no-check-certificate -q "https://events.ccc.de/congress/2015/Fahrplan/schedule.json" -O /tmp/schedule.json && mv /tmp/schedule.json schedule.json
rm -f /tmp/schedule.xml /tmp/schedule.json

# fahrplan
wget --no-check-certificate -q "http://data.c3voc.de/32C3/everything.schedule.xml" -O /tmp/everything.schedule.xml && mv /tmp/everything.schedule.xml everything.schedule.xml
wget --no-check-certificate -q "http://data.c3voc.de/32C3/everything.schedule.json" -O /tmp/everything.schedule.json && mv /tmp/everything.schedule.json everything.schedule.json
rm -f /tmp/everything.schedule.xml /tmp/everything.schedule.json

# vod json
wget -q "http://cdn.c3voc.de/relive/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json
rm -f /tmp/vod.json
