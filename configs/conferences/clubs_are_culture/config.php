<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	'STARTS_AT' => strtotime("2021-02-06 12:45"),

	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2021-02-06 17:00"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	//'CLOSED' => false,

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => '[Open] Club Day 2021',

	/**
	 * Veranstalter
	 * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	//'AUTHOR' => '',

	/**
	 * Beschreibungstext
	 * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'DESCRIPTION' => 'clubsAREculture – Anerkennung von Musikclubs als Kulturstätten  

	Am Samstag, den 6. Februar findet die 4. Ausgabe des europäischen Aktionstags [OPEN] CLUB DAY statt; Pandemie-bedingt in diesem Jahr unter anderen Vorzeichen: Normalerweise vereint der europäische Dachverband Live DMA an diesem Tag Musikclubs und Festivals aus bis zu 17 EU-Ländern, die ihre Türen für Besucher:innen öffnen und Einblicke hinter die Kulissen gewähren. Wie so viele Events muss aber auch diese Veranstaltung ins Virtuelle verlagert werden. Die Veranstalter:innen treten an, den Austausch zwischen Profis, Nachbar:innen, Aktivist:innen, Bürger:innen, Politik und neugierigen Nachtschwärmer:innen zu fördern.  
	
	In Deutschland präsentiert der Bundesverband LiveMusikKommision e.V. (kurz LiveKomm) seine Aktivitäten auch im Rahmen der neuen Aktion von LiveKomm, Clubverbänden, Clubs und Chaos Computer Club (CCC): #clubsAREculture. Dabei geht es ganz aktuell um die Anerkennung von Musikclubs als Kulturstätten in Deutschland.
	Auf der digitalen Konferenz diskutieren Akteur:innen der Szene, Expert:innen und Politiker:innen auf Landes- und Bundesebene miteinander. 
	
	Ab 13 Uhr beginnt das Vorprogramm mit diversen virtuellen Clubführungen, unter anderem im Fundbureau in Hamburg. Um 14:00 Uhr widmen sich eine Reihe von Landes-Panels (u.a. in Baden-Württemberg, Bayern, Berlin, Brandenburg, Bremen, Hamburg und Hessen) der Lage in ihren Bundesländern. Im Anschluss vereinen sich die Diskussionen der Landesverbände ab 15.15 Uhr zur Diskussion auf Bundesebene mit dem Titel:  
	
	“Karstadt raus – Kultur rein? – Post-Corona: Können Musikclubs die Verödung der Innenstädte stoppen?”  
	
	Hierbei diskutieren Dr. Stefan Kaufmann (MdB, CDU, Stuttgart), Kai Wargalla (MdBB, GRÜNE, Bremen), Tanja Kohnen (Deutscher Städtetag) und Barbara Foerster (Amtsleiterin Kulturamt Stadt Köln) mit den Moderatoren Marc Wohlrabe (LiveKomm Vorstand/ Stadt nach Acht Konferenz) & Thore Debor (Clubkombinat Hamburg / Sprecher der LiveKomm AG Kulturraumschutz). 
	
	Zum Abschluss sendet die Berliner Initiative United We Stream ein [Open] Club Day Special.
	
	Die gesamte Veranstaltung wird durch den Chaos Computer Club (CCC) unterstützt und durch die LiveKomm AG Kulturraumschutz kuratiert. Die Streams werden kostenfrei auf www.clubsareculture.de bereitgestellt.  
	
	Ablauf und Programmpunkte: 
	
	13.00h – 13.45h Vorprogramm: u.a. virtuelle Club-Führung Fundbureau (HH)  
	
	14.00h – 15.00h Parallele Diskussionen in den Bundesländern 
	
	15.15h – 16.45h Bundes-Panel: “Karstadt raus – Kultur rein? – Post-Corona: Können Musikclubs die Verödung der Innenstädte stoppen?”
	
	Ab 17.00h United We Stream: [Open] Club Day Special
		
',

	/**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => 'Clubs',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		by <a href="https://www.clubsareculture.de/">https://www.clubsareculture.de/</a> with friendly support from the <a href="https://c3voc.de">C3VOC</a>
	',

	/**
	 * HTML-Code für den Banner (nur auf der Startseite, direkt unter dem Header)
	 * wird üblicherweise für KeyVisuals oder Textmarke verwendet (vgl. Blaues
	 * Wischiwaschi auf http://media.ccc.de/)
	 *
	 * Dieser HTML-Block wird üblicherweise in der main.less speziell für die
	 * Konferenz umgestaltet.
	 *
	 * Wird diese Zeile auskommentiert, wird kein Banner ausgegeben.
	 */
	'BANNER_HTML' => '<div class="logo"></div>',

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	//'RELEASES' => 'https://media.ccc.de/c/osc18',
	//'RELEASES' => 'https://www.youtube.com/playlist?list=PL_AMhvchzBaeIQntCDiVNUUgmRaAzam1V',

	/**
	 * Link zu einer (externen) ReLive-Übersichts-Seite
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	//'RELIVE' => 'http://vod.c3voc.de/',

	/**
	 * Alternativ kann ein ReLive-Json konfiguriert werden, um die interne
	 * ReLive-Ansicht zu aktivieren.
	 *
	 * Wird beides aktiviert, hat der externe Link Vorrang!
	 * Wird beides auskommentiert, wird der Link nicht angezeigt
	 */
	// 'RELIVE_JSON' => '',

	/**
	 * APCU-Cache-Zeit in Sekunden
	 * Wird diese Zeile auskommentiert, werden die apc_*-Methoden nicht verwendet und
	 * das Relive-Json bei jedem Request von der Quelle geladen und geparst
	 */
	//'RELIVE_JSON_CACHE' => 30*60,
);

/**
 * Konfiguration der Stream-Übersicht auf der Startseite
 */
$CONFIG['OVERVIEW'] = array(
	/**
	 * Abschnitte aud der Startseite und darunter aufgeführte Räume
	 * Es können beliebig neue Gruppen und Räume hinzugefügt werden
	 *
	 * Die Räume müssen in $CONFIG['ROOMS'] konfiguriert werden,
	 * sonst werden sie nicht angezeigt.
	 */
	'GROUPS' => array(
		'Lecture rooms' => array(
			'bremen',
			'bawue',
			'hessen',
			'hamburg',
			'berlin',
			'brandenburg',
			'niedersachsen',
			'bayern',
			'sachsen',
		),
	),
);



/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	/**
	 * Array-Key ist der Raum-Slug, der z.B. auch zum erstellen der URLs,
	 * in $CONFIG['OVERVIEW'] oder im Feedback verwendet wird.
	 */
	'bremen' => array(
		'DISPLAY' => 'Bremen',
		'STREAM' => 'bremen',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'SCHEDULE_NAME' => '',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
	'bawue' => array(
		'DISPLAY' => 'Baden Würtenberg',
		'STREAM' => 'bawue',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'SCHEDULE_NAME' => '',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
	'hessen' => array(
		'DISPLAY' => 'Hessen',
		'STREAM' => 'hessen',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'SCHEDULE_NAME' => '',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
	'hamburg' => array(
		'DISPLAY' => 'Hamburg',
		'STREAM' => 'hamburg',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'SCHEDULE_NAME' => '',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
	'berlin' => array(
		'DISPLAY' => 'Berlin',
		'STREAM' => 'berlin',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'SCHEDULE_NAME' => '',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
	'brandenburg' => array(
		'DISPLAY' => 'Brandenburg',
		'STREAM' => 'brandenburg',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'SCHEDULE_NAME' => '',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
	'niedersachsen' => array(
		'DISPLAY' => 'Niedersachen',
		'STREAM' => 'niedersachsen',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'SCHEDULE_NAME' => '',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
	'bayern' => array(
		'DISPLAY' => 'Bayern',
		'STREAM' => 'bayern',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'SCHEDULE_NAME' => '',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
	'sachsen' => array(
		'DISPLAY' => 'Sachsen',
		'STREAM' => 'sachsen',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'SCHEDULE_NAME' => '',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),


);

/**
 * Globaler Schalter für die Embedding-Funktionalitäten
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Embedding-Funktionen deaktiviert.
 */
$CONFIG['EMBED'] = true;

/**
 * Konfigurationen zum Konferenz-Fahrplan
 * Wird dieser Block auskommentiert, werden alle Fahrplan-Bezogenen Features deaktiviert
 */
//$CONFIG['SCHEDULE'] = array(
	/**
	 * URL zum Fahrplan-XML
	 *
	 * Diese URL muss immer verfügbar sein, sonst können kann die Programm-Ansicht
	 * aufhören zu funktionieren. Wenn die Quelle unverlässlich ist ;) sollte ein
	 * externer HTTP-Cache vorgeschaltet werden.
	 */
//	'URL' => 'https://events.opensuse.org/conference/oSC18/schedule.xml',

	/**
	* Nur die angegebenen Räume aus dem Fahrplan beachten
	*
	* Wird diese Zeile auskommentiert, werden alle Räume angezeigt
	*/
	//'ROOMFILTER' => ['Galerie', 'Saal', ' GI Studio'],

	/**
	 * Skalierung der Programm-Vorschau in Sekunden pro Pixel
	 */
//	'SCALE' => 5,

	/**
	 * Simuliere das Verhalten als wäre die Konferenz bereits heute
	 *
	 * Diese folgende Beispiel-Zeile Simuliert, dass das
	 * Konferenz-Datum 2014-12-29 auf den heutigen Tag 2015-02-24 verschoben ist.
	 */
	//'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2016-05-21') - strtotime(/* Today */ '2016-05-19'),
//	'SIMULATE_OFFSET' => 3600*2,
//);
// 

/**
 * Globale Konfiguration der Twitter-Links.
 *
 * Wird dieser Block auskommentiert, werden keine Twitter-Links mehr erzeugt. Sollen die
 * Twitter-Links für jeden Raum einzeln konfiguriert werden, muss dieser Block trotzdem
 * existieren sein. ggf. einfach auf true setzen:
 *
 *   $CONFIG['TWITTER'] = true
 */
$CONFIG['TWITTER'] = array(
	/**
	 * Anzeigetext für die Twitter-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Ist eine weitere Anpassung erfoderlich, kann ein TWITTER_CONFIG-Block in der
	 * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
	 */
	'DISPLAY' => '#debate @ twitter',

	/**
	 * Vorgabe-Tweet-Text für die Twitter-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 */
	'TEXT' => '#debate',
);

$CONFIG['IRC'] = array(
    /**
     * Anzeigetext für die IRC-Links.
     *
     * %s wird durch den Raum-Slug ersetzt.
     * Ist eine weitere Anpassung erfoderlich, kann ein IRC_CONFIG-Block in der
     * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
     */
    'DISPLAY' => '#debate @ hackint',

    /**
     * URL für die IRC-Links.
     * Hierbei kann sowohl ein irc://-Link als auch ein Link zu einem
     * WebIrc-Provider wie z.B. 'https://kiwiirc.com/client/irc.hackint.eu/#33C3-%s'
     * verwendet werden.
     *
     * %s wird durch den urlencodeten Raum-Slug ersetzt.
     * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
     */
    'URL' => 'https://webirc.hackint.org/#irc://irc.hackint.org/#debate',
);

return $CONFIG;
