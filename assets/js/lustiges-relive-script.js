// mediaelement-player
$(function() {
	(function(strings) {
		strings['en-US'] = {
			'Download File': 'Open HLS-Stream in Desktop-Player'
		}
	})(mejs.i18n.locale.strings);

	$('video').mediaelementplayer({
		mode: 'auto_plugin',

		// hack z-index so that the flash plugin get's the click on the fullscreen button
		enableAutosize: true,

		pluginPath: 'assets/js/lib/relive/',
	});
});
