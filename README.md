# C3VOC Streaming-Webseite

Dies ist der Code für die Streaming-Webseite unter
[streaming.media.ccc.de](http://streaming.media.ccc.de/), welche vom
[C3VOC](https://c3voc.de/) benutzt wird, um Live-Video- und -Audio-Streams von
[diversen Konferenzen](https://c3voc.de/eventkalender/) im Internet zu
präsentieren. Die Idee hinter diesem Projekt ist es, eine generische Codebasis
zu haben, die mit wenigen Konfigurationsoptionen und ein paar CSS-Rules an die
Gegebenheiten und die Gestaltung der Konferenz angepasst werden können. 


## Development

Während der Entwicklung kann der eingebaute PHP-Webserver verwendet werden:
```
$ ./serve.sh
PHP 7.0.4-7ubuntu2.1 Development Server started at Mon Jun 20 22:40:17 2016
Listening on http://localhost:8000
Document root is /home/peter/VOC/streaming-website
Press Ctrl-C to quit.
…
```

Unterstützt wird PHP ab 5.4.

### Abhängigkeiten

```
apt install php7.0-curl php7.0-xml
# - or -
apt install php-curl php-xml
```

#### Dateidownload testen

```
./download.sh
```

## Konfiguration der einzelnen Konferenzen

Die Seite kann für mehrere parallel laufende Konferenzen gleichzeitig verwendet
werden. Jede Konferenz wird über einen Ordner unterhalb von
[configs/conferences](configs/conferences) konfiguriert. In diesen Ordnern können
jeweils folgende Dateien abgelegt werden, welche das Verhalten bzw. die Gestaltung
der jeweiligen Konferenzseite bestimmen, im Folgendem am :

  - [config.php](configs/conferences/nixcon15/config.php) – steuert das Verhalten der gesamten Konferenzseite. Diese ist ausführlich dokumentiert und sollte sich selbst erklären.
  - [main.less](configs/conferences/nixcon15/main.less) – steuert die Gestaltung der Konferenzseite.
  - weitere Assets wie `.png` oder `.svg`-Dateien, die aus der `main.less` heraus referenziert werden können.

Siehe auch https://c3voc.de/wiki/software:streamingwebsite#add_a_new_conference

## Setup

Das Setup beim VOC besteht aus einem Hidden-Master-Server, welcher den PHP-Code
in einem nginx ausführt. Dahinter kommen `n` Frontend-Caches, wobei für kleine
Events `n` eigentlich fast immer `=1` ist. Für große Events (Camp, Congress)
können wir aber sehr einfach weitere Frontend-Caches bei verschiedenen Hostern
hinzu deployen.

Zur Vorbereitung einer Konferenz oder zur Weiterentwickelung der Seite ist es
hilfreich, sich das Teil lokal aufzusetzen. Am einfachsten geht das mit 'nem
Apachen, denn die beiliegende [.htaccess](.htaccess) konfiguriert das
URL-Rewriting gleich richtig. Bei nginx muss das in der globalen nginx.conf
ungefähr so eingestellt werden:

```
location / {
    rewrite /(.*) /index.php?route=$1 last;
}
```

Abweichend von der Default-Config muss in PHP das Flag `short_open_tag = On`
gesetzt werden.



## Deployment (auf der VOC Infrastruktur)

see [deploy.sh](deploy.sh) bzw. https://c3voc.de/wiki/software:streamingwebsite


## JSON-API

Unter der URL [http://streaming.media.ccc.de/streams/v2.json](http://streaming.media.ccc.de/streams/v2.json) bietet die
Streaming-Webseite eine Übersicht über alle konfigurierten Räume und Streams in
einem maschinenlesbaren Format an. Dieses kann z.B. genutzt werden, um in den
diversen Anwendungen, die sich rund um das Konferenzgeschehen entwickelt haben,
Player und Links zu Liveübertragungen anzubieten.

Wie die URL vermuten lässt, ist die API versioniert. Dies bedeutet, dass in
der `v2.json` keine Felder *entfernt werden* oder ihre *Bedeutung ändern* – es
können aber durchaus *neue Felder* hinzukommen. Eine formalere Spezifikation
des JSON-Formats ist tbd. Ein Beispiel kann [hier
betrachtet](https://gist.github.com/MaZderMind/a91f242efb2f446a2237d4596896efd6) werden.

### Bekannte Nutzer der API

  - [Kodi media.ccc.de Plugin](https://github.com/cccc/plugin.video.media-ccc-de)
    - v2
    - [API Kompatibilitätstest](https://github.com/cccc/plugin.video.media-ccc-de/blob/master/resources/lib/test_stream.py)
  - [re-data](https://github.com/ocdata/re-data/tree/feature/34c3)
    - Scraping code: [https://github.com/ocdata/re-data/blob/feature/34c3/scraper/34C3/scraper.js](https://github.com/ocdata/re-data/blob/feature/34c3/scraper/34C3/scraper.js)
    - During events data appears here: [http://api.conference.bits.io/](http://api.conference.bits.io/)

## Troubleshooting

### Falsche PHP-Version

Wenn `serve.sh` einen Fehler wirft wie z.B. `PHP Fatal error:  Uncaught ErrorException: Required parameter $rules follows optional parameter $value in /<path-to-repository>/lib/less.php/Less.php:5501` kann es sein, dass du eine falsche PHP-Version verwendest. Wenn `php --version` 8 oder neuer zurückgibt, dann ist deine Version zu neu. Versuche auf deinem Betriebssystem PHP 7.4 zu installieren und in den Skripts, die zu benötigst, die Version anzupassen. Zum Beispiel wird dann aus
```
// vorher
php -S localhost:$port -d short_open_tag=true index.php
```
dann
```
//nachher
php7.4 -S localhost:$port -d short_open_tag=true index.php
```

### Fehlermeldung `Call to undefined function iconv()`
Wenn du beim Aufrufen der Seite im Browser nur eine leere Seite siehst, schau in dein Terminal, ob es einen Fehler gab. Wenn du einen Fehler wie `PHP Fatal error:  Uncaught Error: Call to undefined function iconv()` siehst, ist bei dir die iconv-Extention nicht aktiviert. Du kannst diese in deiner globalen `php.ini` aktivieren. Wo diese Datei liegt kannst du mit `php --ini` bzw. `php7 --ini` rausfinden. Suche in der Datei nach der richtigen Zeile und entferne das Semikolon am Anfang. Wenn es kein Semikolon gibt, sollte die Extension bereits aktiviert sein.
```
// vorher
;extension=iconv
```
```
// nachher
extension=iconv
```

### Fehlermeldung `lessc: command not found`
Wenn du beim Ausführen von Skripten den Fehler `lessc: command not found` bekommst, fehlt dir ein less-Compiler. Es gibt verschiedene Arten, sich einen less-Compiler zu installieren. Falls du `npm` verwendest, kannst du beispielsweise less global installieren mit `npm install -g less`. Anschließen sollte `lessc` dann global auf deinem System verfügbar sein.
