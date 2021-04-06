#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://rome.rustfest.eu/schedule.xml" -O /tmp/rfrome18-schedule.xml && mv /tmp/rfrome18-schedule.xml schedule.xml
rm -f /tmp/rfrome18-schedule.xml
