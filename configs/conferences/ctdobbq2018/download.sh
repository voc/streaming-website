#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://pretalx.ctdo.de/bbq18/schedule/export?exporter=core-frab-xml" -O /tmp/ctdobbq18-schedule.xml && mv /tmp/ctdobbq18-schedule.xml schedule.xml
rm -f /tmp/ctdobbq18-schedule.xml
