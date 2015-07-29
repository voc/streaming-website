# c3voc Streaming-Webseite

Dies ist der Code für die Streaming-Webseite unter [streaming.media.ccc.de](http://streaming.media.ccc.de/) welche vom [c3voc](https://c3voc.de/) benutzt wird um Live-Video und -Audio-Streams von [diversen Konferenzen](https://c3voc.de/eventkalender/) inm Internet zu präsentieren. Die Idee hinter diesem Projekt ist es, eine generische Codebasis zu haben, die mit wenigen Konfigurationsoptionen und ein paar CSS-Rules an die Gegebenheiten und die Gestaltung der Konferenz angepasst werden können.



## Setup

Das Setup beim VOC besteht aus einem Hidden-Master-Server, welcher den PHP-Code in einem nginx ausführt. Dahinter kommen n Frontend-Caches, wobei für kleine Events n eigentlich fast immer =1 ist. Für große Events (Camp, Congress), können wir aber sehr einfach weitere Frontend-Caches bei verschiedenen Hostern hinzu deployen.

Zum vorbereiten einer Konferenz oder weiterentwickeln der Seite ist es hilfreich, sich das Teil lokal aufzusetzen. Am einfachsten geht das mit nem Apachen denn die beiliegende [.htaccess](.htaccess) konfiguriert das URL-Rewriting gleich richtig. Bei nginx muss das in der globalen nginx.conf ungefähr so eingestellt werden:
````
    location / {
      rewrite /(.*) /index.php?route=$1 last;
    }
````

Abweichend von der Default-Config muss in PHP das Flag `short_open_tag = On` gesetzt werden.

Die CSS-Styles sind in [less-css](http://lesscss.org/) geschrieben und es wird ein less-Compiler benötigt, um diese in CSS-Dateien umzuwandeln. Der Einfachste Weg ist [node.js](https://nodejs.org/) über das [Debian-Repo](https://github.com/joyent/node/wiki/Installing-Node.js-via-package-manager#debian-and-ubuntu-based-linux-distributions) installieren und dann mit `npm install -g less` den `lessc`-Compiler installieren. Zum korrekten bauen der Less-Datei kann das makefile in [assets/css](assets/css/) verwendet werden.



## Konfiguration

Die Gesamte Seite wird von der zentralen [config.php](config.php)-Datei gesteuert. Diese ist ausführlich dokumentiert und sollte sich selbst erklären.

Für die Konferenztypische Gestaltung kann in der [main.less](assets/css/main.less) nach Wunsch ausgestaltet werden. Als Beispiel sei hier die Gestaltung für das [Easterhegg 2015](https://eh15.easterhegg.eu/site/) verlinkt: [d3c0e74](https://github.com/voc/streaming-website/commit/d3c0e74f459121c3e624c9b3b92d6ec6b39a3dbe)

Üblicherweise machen wir für jede Veranstaltung einen `events/XXXX` branch auf, wobei XXXX das Acronym der Konferenz ist.



## Deployment (auf der VOC Infrastruktur)
````
	ssh voc@live.ber
	cd /srv/nginx/streaming-website
	git fetch origin
	git checkout <branch>

	cd assets/css
	make
	sudo sh -c 'rm -rf  /srv/nginx/cache/streaming_fcgi/*'
	exit

	ssh voc@live.dus
	sudo sh -c 'rm /srv/nginx/cache/streaming_website/static/* /srv/nginx/cache/streaming_website/pages/*'
	exit
````


## JSON-API

Unter der URL http://streaming.media.ccc.de/streams/v1.json bietet die Steaming-Webseite eine Übersicht über alle konfigurierten Räume und Streams in einem Maschienenlesbaren Format an. Dieses kann z.B. genutzt werden, um in den diversen Anwendungen die sich rund um das Konferenzgeschehen entwickelt haben Player und Links zu Liveübertragungen anzubieten.

Wie die URL vermuten lässt, ist die API versionionert. Dies bedeutet, dass in der v1.json keine Felder *entfernt werden* oder ihre *bedeutung ändern* – es können aber durchaus *neue Felder* hinzukommen. Eine formalere Spezifikation des JSON-Formats ist tbd. Ein Beispiel kann [hier betrachtet](https://gist.github.com/MaZderMind/d5737ab867ade7888cb4) werden.
