#!/bin/sh
while true; do
	ffmpeg -y -v warning -i rtmp://rtmp.stream.c3voc.de:1935/stream/s1_native_sd -vf "scale=213:120" -vframes 1 saal1.png
	optipng saal1.png

	ffmpeg -y -v warning -i rtmp://rtmp.stream.c3voc.de:1935/stream/s2_native_sd -vf "scale=213:120" -vframes 1 saal2.png
	optipng saal2.png

	ffmpeg -y -v warning -i rtmp://rtmp.stream.c3voc.de:1935/stream/s3_native_sd -vf "scale=213:120" -vframes 1 saalg.png
	optipng saalg.png

	ffmpeg -y -v warning -i rtmp://rtmp.stream.c3voc.de:1935/stream/s4_native_sd -vf "scale=213:120" -vframes 1 saal6.png
	optipng saal6.png

	sleep 1
done
