#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://n621.de/fud/nixcon.xml" -O /tmp/nixcon2015-schedule.xml && mv /tmp/nixcon2015-schedule.xml schedule.xml

# relive
wget --no-check-certificate -q "http://live.ber.c3voc.de/releases/relive/nixcon2015/index.json" -O /tmp/nixcon2015-relive.json && mv /tmp/nixcon2015-relive.json relive.json

