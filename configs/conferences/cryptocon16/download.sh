#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://events.sublab.io/en/CC16/public/schedule.xml" -O /tmp/cryptocon16-schedule.xml && mv /tmp/cryptocon16-schedule.xml schedule.xml
