#!/bin/sh
# Usage: ./serve.sh [HTTP-PORT] [DEBUG-HOST] [DEBUG-PORT]

port=""
dhost="127.0.0.1"
dport=9000

if [ -n "$1" ]; then
        port=$1
	shift
fi

if [ -n "$1" ]; then
        dhost=$1
	shift
fi

if [ -n "$1" ]; then
        dport=$1
	shift
fi

./serve.sh "$port" -dxdebug.remote_enable=1 -dxdebug.remote_port=$dport -dxdebug.remote_host=$dhost $*
