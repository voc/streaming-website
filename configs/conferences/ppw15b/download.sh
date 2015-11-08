#!/bin/sh

# fahrplan
wget --no-check-certificate -q "https://frab.sendegate.de/en/ppw15b/public/schedule.xml" -O /tmp/schedule.xml && mv /tmp/schedule.xml schedule.xml
