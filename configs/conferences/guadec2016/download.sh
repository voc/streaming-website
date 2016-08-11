#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://static.gnome.org/guadec-2016/schedule.xml" -O /tmp/guadec2016-schedule.xml && mv /tmp/guadec2016-schedule.xml schedule.xml
rm -f /tmp/guadec2016-schedule.xml

# relive
wget -q "http://live.dus.c3voc.de/relive/guadec2016/index.json" -O /tmp/guadec2016-vod.json && mv /tmp/guadec2016-vod.json vod.json
rm -f /tmp/guadec2016-vod.json
