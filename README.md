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



## Konfiguration

Die Seite kann für mehrere parallel laufende Konferenzen gleichzeitig verwendet
werden. Jede Konferenz wird über einen Ordner unterhalb von
[configs/conferences](configs/conferences) konfiguriert. In diesen Ordnern können
jeweils folgende Dateien abgelegt werden, welche das Verhalten bzw. die Gestaltung
der jeweiligen Konferenzseite bestimmen, im Folgendem am :

  - [config.php](configs/conferences/nixcon15/config.php) – steuert das Verhalten der gesamten Konferenzseite. Diese ist ausführlich dokumentiert und sollte sich selbst erklären.
  - [download.sh](configs/conferences/nixcon15/download.sh) – Wird von einem Cronjob in regelmäßigen Abständen zum Herunterladen von `schedule.xml`-Dateien und anderen Drittkonfiguration verwendet.
  - [main.less](configs/conferences/nixcon15/main.less) – steuert die Gestaltung der Konferenzseite.
  - weitere Assets wie `.png` oder `.svg`-Dateien, die aus der `main.less` heraus referenziert werden können.



## Deployment (auf der VOC Infrastruktur)

see [deploy.sh](deploy.sh)


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
