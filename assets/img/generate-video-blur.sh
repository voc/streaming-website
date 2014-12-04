#!/bin/sh
ffmpeg -y -i rtmp://rtmp.stream.c3voc.de:1935/stream/s1_native_hd -vframes 1 -vf 'boxblur=lr=50:cr=25' video-blur.jpg
