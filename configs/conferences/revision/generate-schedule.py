#!/usr/bin/env python3

import requests
import hashlib
import dateutil.parser
import pytz
import datetime
import slugify

xml = """<?xml version='1.0' encoding='utf-8' ?>
<schedule>
  <generator name='lukas lustiges script' version='0.1'></generator>
  <version>0.1 a schedule</version>
  <conference>
    <acronym>revision</acronym>
    <title>Revision 2022</title>
    <start>2022-04-15</start>
    <end>2022-04-18</end>
    <days>4</days>
    <timeslot_duration>00:05</timeslot_duration>
    <base_url>https://2022.revision-party.net/events/timetable/</base_url>
  </conference>
"""

def guid(*args):
    digest = hashlib.md5("-".join(args).encode()).hexdigest()
    return digest[0:8] + "-" + digest[8:12] + "-" + digest[12:16] + "-" + digest[16:20] + "-" + digest[20:]

event_count = 0

all_events = []
for day in requests.get("https://2022.revision-party.net/timetable.json").json()["timetable"]:
    for event in day["events"]:
        date = dateutil.parser.parse(event['start']).astimezone(pytz.timezone("Europe/Berlin"))
        all_events.append((date.day - 15, event, date))

for i in range(4):
    xml += "  <day date='2022-04-%d' start='2022-04-%dT23:59:59+02:00' end='2022-04-%dT23:59:59+02:00' index='%d'>\n" % (15+i, 15+i, 15+i, i+1)
    xml += "    <room name='Revision'>\n"
    for c, day, event, date in [(c, *x) for c, x in enumerate(all_events) if x[0] == i]:
        event_count += 1
        xml += "      <event guid='%s' id='%d'>\n" % (guid(event["title"], event["category"], event["start"]), event_count)
        title = event["title"].replace("\n", ", ")
        if len(title) > 43:
            title = title[:40] + "..."
        xml += "        <title>%s</title>\n" % title
        xml += "        <slug>%s</slug>\n" % slugify.slugify("REVISION" + "-" + str(c+1) + "-" + event["category"] + "-" + event["title"])
        xml += "        <subtitle></subtitle>\n"
        xml += "        <room>Revision</room>\n"
        xml += "        <track>%s</track>\n" % event["category"]
        xml += "        <date>%s</date>\n" % date.isoformat()
        xml += "        <start>%s</start>\n" % date.strftime("%H:%M")
        if len(all_events) > (c + 1):
            nextevent = all_events[c+1][2]
        else:
            nextevent = date + datetime.timedelta(minutes=15)
        #xml += "        <end>%s</end>\n" % nextevent.strftime("%H:%M")
        duration = nextevent - date
        duration_mins = (duration.total_seconds() // 60) % 60
        duration_hours = (duration.total_seconds() // 60) // 60
        if duration_hours > 6:
            duration_hours = 1
            duration_mins = 0
        xml += "        <duration>%02d:%02d</duration>\n" % (duration_hours, duration_mins)
        xml += "        <language>en</language>\n"
        xml += "        <type>lecture</type>\n"
        xml += "        <recording><license/><optout>false</optout></recording>\n"
        xml += "        <url>https://2022.revision-party.net</url>\n"
        xml += "        <abstract/>\n"
        xml += "        <description/>\n"
        xml += "        <logo/>\n"
        xml += "        <persons><person id='1'>Revision</person></persons>\n"
        xml += "        <links/>\n"
        xml += "        <attachments/>\n"
        xml += "      </event>\n"
    xml += "    </room>\n"
    xml += "  </day>\n"

xml += "</schedule>"

print(xml)


