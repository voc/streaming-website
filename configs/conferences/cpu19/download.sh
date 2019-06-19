#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://pretalx.chaos-party-ulm.de/cpu19/schedule/export/schedule.xml" -O /tmp/cpu19-schedule.xml && mv /tmp/cpu19-schedule.xml schedule.xml

# relive
wget --no-check-certificate -q "http://live.ber.c3voc.de/releases/relive/cpu19/index.json" -O /tmp/cpu19-relive.json && mv /tmp/cpu19-relive.json relive.json
