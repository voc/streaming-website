#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://paris.rustfest.eu/schedule.xml" -O /tmp/rf18-schedule.xml && mv /tmp/rf18-schedule.xml schedule.xml
rm -f /tmp/rf18-schedule.xml
