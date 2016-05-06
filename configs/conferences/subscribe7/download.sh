#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://frab.sendegate.de/de/subscribe7/public/schedule.xml" -O /tmp/subscribe7-schedule.xml && mv /tmp/subscribe7-schedule.xml schedule.xml

# relive
wget --no-check-certificate -q "http://live.ber.c3voc.de/releases/relive/subscribe7/index.json" -O /tmp/subscribe7-relive.json && mv /tmp/subscribe7-relive.json relive.json
