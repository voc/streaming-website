#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://frab.sendegate.de/en/ppw15b/public/schedule.xml" -O /tmp/ppw15b-schedule.xml && mv /tmp/ppw15b-schedule.xml schedule.xml

# relive
wget --no-check-certificate -q "http://live.ber.c3voc.de/releases/relive/ppw15b/index.json" -O /tmp/ppw15b-relive.json && mv /tmp/ppw15b-relive.json relive.json
