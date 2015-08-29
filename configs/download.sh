#!/bin/sh

# fahrplan
wget -q "http://mrmcd.net/2015/fahrplan/schedule.xml" -O /tmp/schedule.xml && mv /tmp/schedule.xml schedule.xml

# vod json
wget -q "http://cdn.c3voc.de/releases/relive/index.json" -O /tmp/vod.json && mv /tmp/vod.json vod.json

# eventkalender upcoming
wget -q --no-check-certificate "https://c3voc.de/eventkalender/events.json?filter=upcoming" -O /tmp/upcoming.json && mv /tmp/upcoming.json upcoming.json
