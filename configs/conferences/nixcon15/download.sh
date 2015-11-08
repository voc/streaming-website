#!/bin/sh

# fahrplan
wget --no-check-certificate -q "http://n621.de/fud/nixcon.xml" -O /tmp/schedule.xml && mv /tmp/schedule.xml schedule.xml
