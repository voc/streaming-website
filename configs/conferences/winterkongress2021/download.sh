#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://cfp.digitale-gesellschaft.ch/wk04/schedule.xml" -O /tmp/winterkongress2021-schedule.xml && mv /tmp/winterkongress2021-schedule.xml schedule.xml

# relive
wget --no-check-certificate -q "https://relive.c3voc.de/relive/winterkongress2021/index.json" -O /tmp/winterkongress2021-relive.json && mv /tmp/winterkongress2021-relive.json relive.json

