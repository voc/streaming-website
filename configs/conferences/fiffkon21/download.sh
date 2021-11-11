#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://pretalx.c3voc.de/fiffkon2021/schedule/export/schedule.xml" -O /tmp/fiffkon21-schedule.xml && mv /tmp/fiffkon21-schedule.xml schedule.xml

# relive
#wget --no-check-certificate -q "https://relive.c3voc.de/relive/winterkongress2021/index.json" -O /tmp/winterkongress2021-relive.json && mv /tmp/winterkongress2021-relive.json relive.json

