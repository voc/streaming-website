$(function() {

	$('video').mediaelementplayer({
		usePluginFullScreen: true,

		pluginPath: 'assets/js/lib/',
		enableAutosize: true,
		features: ['playpause', 'volume','fullscreen'],

		success: function (mediaElement) {
			/*
			mediaElement.addEventListener('playing', function () {
				$.post("http://api.media.ccc.de/public/recordings/count", {event_id: 1609,src: mediaElement.src});
			}, false);
			*/
		}
	});
	$('audio').mediaelementplayer();

/*
	// activate tab via hash and default to video
	function setTabToHash() {
		var activeTab = $('.nav-tabs a[href=' + window.location.hash + ']').tab('show');

		if (activeTab.length === 0) {
			window.location.hash = '#video';
		}
	}
	setTabToHash();


	// change hash on tab change
	$('.nav-tabs').on('shown.bs.tab', 'a', function (e) {
		window.location.hash = e.target.hash;
	});

	// adjust tabs when hash changes
	$(window).on('hashchange', setTabToHash);
*/
});
