#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://www.emfcamp.org/schedule.frab" -O /tmp/emf2018-schedule.xml && mv /tmp/emf2018-schedule.xml schedule.xml
rm -f /tmp/emf2018-schedule.xml

# relive
#wget -q "http://live.dus.c3voc.de/relive/emf2016/index.json" -O /tmp/emf2016-vod.json && mv /tmp/emf2016-vod.json vod.json
#rm -f /tmp/emf2016-vod.json
