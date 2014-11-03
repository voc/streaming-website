$(function() {

	$('video').mediaelementplayer({
		mode: 'auto_plugin',
		usePluginFullScreen: true,
		enableAutosize: true,

		pluginPath: 'assets/js/lib/',
		features: ['playpause', 'volume','fullscreen']
	});
	$('audio').mediaelementplayer();

	// activate tab via hash and default to video
	function setTabToHash() {
		var activeTab = $('.nav-tabs a[href=' + window.location.hash + ']').tab('show');
	}

	// change hash on tab change
	$('.nav-tabs').on('shown.bs.tab', 'a', function (e) {
		window.location.hash = e.target.hash;
	});

	// adjust tabs when hash changes
	$(window).on('hashchange', setTabToHash).trigger('hashchange');

	$('.click-to-irc').on('click', function(e) {
		if($(this).hasClass('activating'))
			return;

		if($(e.target).hasClass('irclink'))
			return;

		var
			$irc = $(this).addClass('activating'),
			$iframe = $(this).find('iframe');

		$iframe.on('load', function() {
			$irc.addClass('active');
		}).attr('src', $iframe.data('src'));
	});
});
