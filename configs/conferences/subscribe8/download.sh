#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://frab.sendegate.de/de/subscribe8/public/schedule.xml" -O /tmp/subscribe8-schedule.xml && mv /tmp/subscribe8-schedule.xml schedule.xml

# relive
wget --no-check-certificate -q "http://live.ber.c3voc.de/releases/relive/subscribe8/index.json" -O /tmp/subscribe8-relive.json && mv /tmp/subscribe8-relive.json relive.json
