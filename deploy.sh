#!/bin/sh
ssh voc@lb.dus.c3voc.de 'sudo sh' << EOT
cd /srv/nginx/streaming-website
git fetch origin
git reset --hard origin/master
chown -R voc:staff .
chown -R downloader configs/conferences
EOT
