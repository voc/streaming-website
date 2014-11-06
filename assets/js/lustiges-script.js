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

	// click-to-irc
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

	var
		$program = $('.program'),
		$now = $program.find('.now'),
		$lastUpcoming,
		manualControl = false,
		doRewind = false,
		rewindTimeout;

	$program.on('mouseenter mouseleave touchstart touchend', function(e) {
		manualControl = (e.type == 'mouseenter');

		if(e.type == 'mouseleave' || e.type == 'touchend') {
			rewindTimeout = setTimeout(function() {
				doRewind = true;
			}, 5000);
		} else {
			clearTimeout(rewindTimeout);
		}
	});

	function interval() {
		// program timing
		var
			offset = $('.program').data('offset'),
			now = (Date.now() / 1000) - offset;

		// find upcoming block
		var $upcoming = $program
			.find('.room')
			.first()
			.find('.block')
			.filter(function(i, el) { 
				return $(this).data('start') < now;
			}).last();

		var
			start = $upcoming.data('start'),
			end = $upcoming.data('end'),
			normalized = Math.max(0, Math.min(1, (now - start) / (end - start))),
			px = $upcoming.position().left + ($upcoming.outerWidth() * normalized);

		//console.log($upcoming.get(0), normalized, px);
		$now.css('width', px);
		if(doRewind || (!$upcoming.is($lastUpcoming) && !manualControl))
		{
			$program.scrollTo($upcoming, {
				axis: 'x',
				offset: -100,
				duration: $lastUpcoming ? 500 : 0
			});
			$lastUpcoming = $upcoming;
			doRewind = false;
		}
	}

	setInterval(interval, 500);
	interval();
});
