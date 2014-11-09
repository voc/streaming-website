// mediaelement-player
$(function() {
	$('video').mediaelementplayer({
		mode: 'auto_plugin',
		usePluginFullScreen: true,
		enableAutosize: true,

		pluginPath: 'assets/js/lib/',
		features: ['playpause', 'volume','fullscreen']
	});
	$('audio').mediaelementplayer();
});


// tabs
$(function() {
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
});


// click-to-irc
$(function() {
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
		scrollLock = false,
		rewindTimeout,
		rewindTime = 10000 /* 10 seconds after manual navigation */,

		scrollDuration = 500 /* 1/2s animation on the scolling element */;

	$program.on('mouseenter mouseleave touchstart touchend', function(e) {
		if(e.type == 'mouseleave' || e.type == 'touchend') {
			rewindTimeout = setTimeout(function() {
				scrollLock = false;
			}, 5000);
		} else {
			clearTimeout(rewindTimeout);
			scrollLock = true;
		}
	});

	// program now-marker & scrolling
	function interval(initial) {
		var
			// offset to the browsers realtime (for simulation
			offset = $('.program').data('offset'),

			// corrected "now" timestamp in unix-counting (seconds, not microseconds)
			now = (Date.now() / 1000) - offset;

		// only check the first room (shouldn't matter anyway)
		// find the newest block that starts in the past
		// that's the one that is most probably currently still running
		var $block = $program
			.find('.room')
			.first()
			.find('.block')
			.filter(function(i, el) { 
				return $(this).data('start') < now;
			}).last();

		var
			// start & end-timestamp
			start = $block.data('start'),
			end = $block.data('end'),

			// place of the now-marker between 0 and 1 within this block
			normalized = Math.max(0, Math.min(1, (now - start) / (end - start))),

			// projected to pixels with respect to the programms left end
			px = $block.position().left + ($block.outerWidth() * normalized),

			// visible width of the program display
			displayw = $program.width(),

			// current scroll position
			scrollx = $program.scrollLeft(),

			// distance of the now-marker to the left border of the program display
			px_in_display = px - scrollx;

		//console.log($block.get(0), new Date(start*1000), new Date(now*1000), new Date(end*1000), normalized, px);
		$now.css('width', px);

		// scrolling is locked by manual interaction
		if(scrollLock)
			return;

		if(
			// now marker is > 2/3 of the program-display-width
			px_in_display > (displayw * 2/3) || 

			// now marker is <1/7 of the program-display-width
			px_in_display < (displayw/7)
		) {
			// scroll program so that now-marker is as 1/5 of the screen
			$program.stop().scrollTo(px - displayw/6, {
				axis: 'x',
				duration: initial ? 0 : scrollDuration,
			});
		}
	}

	// initial trigger
	interval(true);

	// timed triggers
	setInterval(interval, 500);

	// trigger when a tab was changed
	$('.nav-tabs').on('shown.bs.tab', 'a', function (e) {
		interval(true);
	});
});

// slide-stream
$(function() {
	var
		updateTimer = 5000, /* reload slide image 2 seconds after the previous image was loaded */
		$template = $('img.slide.template').clone().detach();

	function updateSlideImage() {console.log('updateSlideImage');
		// no way around breaking the cache hard in FF
		// -> https://bugzilla.mozilla.org/show_bug.cgi?id=295942
		$template
			.clone()
			.on('load', function() {
				$(this).replaceAll($('img.slide'));
				setTimeout(updateSlideImage, updateTimer);
			})
			.attr('src', $template.data('src')+'?'+Date.now());
	}

	updateSlideImage();
});
