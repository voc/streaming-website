#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://events.ccc.de/congress/2014/Fahrplan/schedule.xml" -O /tmp/schedule.xml && mv /tmp/schedule.xml schedule.xml

# vod json
wget -q "http://cdn.c3voc.de/releases/relive/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json

# eventkalender upcoming
wget -q --no-check-certificate "https://c3voc.de/eventkalender/events.json?filter=upcoming&streaming=yes" -O /tmp/upcoming.json && mv /tmp/upcoming.json upcoming.json
