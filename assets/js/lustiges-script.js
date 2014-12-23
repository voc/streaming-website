$.fn.pulseSubsLine = function(klass) {
	var e = this;
	e
		.find('.text')
			.hide()
		.end()
		.addClass(klass)
		.animate({opacity: 1, duration: .75}, function() {
			setTimeout(function() {
				e.animate({opacity: 0, duration: .5}, function() {
					e.removeClass(klass);
				})
			}, 5000);
		});
}

$.fn.autoScale = function() {
	if(!this.data('autoScaleOriginal')) {
		this.data('autoScaleOriginal', parseInt(this.css('font-size')));
	}

	var
		maxSize = this.data('autoScaleOriginal');
		maxH = this.parent().innerHeight(),
		thisH = this.css('font-size', maxSize).outerHeight();

	while(thisH > maxH && maxSize > 0) {
		thisH = this.css('font-size', --maxSize).outerHeight();
	}

	return this;
}

// mediaelement subtitles button
MediaElementPlayer.prototype.buildsubs = function(player, controls, layers, media) {
	var
		host = 'http://frontend.c3voc.mazdermind.de:33133/',
		room = $('.room.video').data('room'),
		isLoaded = false,
		t = 200,
		$btn = $([
			'<div class="mejs-button mejs-subs-button">',
				'<span class="fa fa-comments-o"></span>',
			'</div>'
		].join('')),
		$line = $([
			'<div class="mejs-subs-line">',
				'<div class="text"></div>',
				'<div class="silence">',
					'<i>(silence)</i>',
					'<br />',
					'Maybe no-one is currently writing Live-Subtitles',
				'</div>',
				'<div class="error">',
					'Sorry, an Error occured.',
				'</div>',
			'</div>'
		].join('')),
		$text = $line.find('.text'),
		$silence = $line.find('.silence'),
		$error = $line.find('.error');



	$btn
		.appendTo(controls)
		.click(function() {
			$.ajax({
				url: host+'status/'+encodeURIComponent(room),
				//dataType: $.support.cors ? 'json' : 'jsonp',
				dataType: 'jsonp',
				success: function(status) {
					if(!status)
						return $line.pulseSubsLine('silence');

					if(!isLoaded) {
						isLoaded = true;
						return loadAndOpenSocket();
					}

					$line.fadeToggle(t);
				},
				error: function() {
					$line.pulseSubsLine('error');
				}
			});
		});

	function loadAndOpenSocket() {
		if(window.io)
			return openSocket();

		$.getScript(host+'socket.io/socket.io.js', openSocket);
	}

	function silence() {
		$text.hide();
		$silence.show().animate({opacity: 1, duration: .75});
	}

	function openSocket() {
		var hideTimeout, silenceTimeout, silenceWait = 15*1000;
		var socket = io(host);

		socket.on('connect', function() {
			$line.animate({opacity: 1}, t);
			socket.emit('join', room);
		});

		silenceTimeout = setTimeout(silence, silenceWait);

		socket.on('line', function(stamp, line, duration) {
			if(hideTimeout)
				clearTimeout(hideTimeout);

			hideTimeout = setTimeout(function() {
				$text.animate({opacity: 0}, t)
				clearTimeout(hideTimeout);
				hideTimeout = null;
			}, duration*1000);


			if(silenceTimeout)
				clearTimeout(silenceTimeout);

			silenceTimeout = setTimeout(silence, silenceWait);


			$text.animate({
				opacity: 0
			}, {
				duration: t,
				complete: function() {
					$text.show().text(line).autoScale().animate({
						opacity: 1
					});
				}
			});
		});
	}

	$line.appendTo(layers);
}

// mediaelement-player
$(function() {
	$('video').mediaelementplayer({
		mode: 'auto_plugin',

		// hack z-index so that the flash plugin get's the click on the fullscreen button
		usePluginFullScreen: true,
		enableAutosize: true,

		pluginPath: 'assets/js/lib/',
		features: ['playpause', 'volume', 'fullscreen', $('video').hasClass('subs') ? 'subs' : '']
	});
	$('audio').mediaelementplayer({
		features: ['playpause', 'volume', 'current']
	});
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
});

// programm-timeline
$(function() {
	var
		$program = $('.program'),
		$now = $program.find('.now'),
		scrollLock = false,
		rewindTimeout,
		rewindTime = 10000, /* 10 seconds after manual navigation */
		scrollDuration = 500, /* 1/2s animation on the scolling element */
		updateTimer = 500; /* update now-pointer placement every 1/2s */

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
	function updateProgramView(initial) {
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

		if($block.length == 0)
			return $now.css('width', 0);

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


	// when on programs tab
	var updateInterval;
	function on() {
		// initial trigger
		updateProgramView(true);

		// timed triggers
		updateInterval = setInterval(updateProgramView, updateTimer);
	}

	function off() {
		clearInterval(updateInterval);
	}

	if(window.location.hash == '#program')
		on();

	// trigger when a tab was changed
	$('.nav-tabs').on('shown.bs.tab', 'a', function(e) {
		if(e.target.hash == '#program')
			on();
		else
			off();
	});
});

// startpage program teaser
$(function() {
	var
		updateTimer = 5*1000, /* update display every 5 seconds */
		refetchTimer = 10*60*1000, /* re-request current / upcoming program every 10 minutes */
		programData = {},
		$lecture = $('.rooms .lecture');


	if($lecture.length == 0)
		return;

	function fetchProgram() {
		$.ajax({
			url: 'program.json',
			dataType: 'json',
			success: function(data) {
				programData = data;
				updateProgtamTeaser();
			},

			// success & error
			complete: function() {
				setTimeout(fetchProgram, refetchTimer);
			}
		});
	}

	function updateProgtamTeaser() {
		var
			// offset to the browsers realtime (for simulation
			offset = $lecture.data('offset'),

			// corrected "now" timestamp in unix-counting (seconds, not microseconds)
			now = (Date.now() / 1000) - offset;

		$.each(programData, function(room, talks) {
			var currentTalk, nextTalk;

			$.each(talks, function(room, talk) {

				if(talk.start < now)
					currentTalk = talk;

				if(!nextTalk && !talk.special && talk.start > now)
					nextTalk = talk;

			});

			var s = new Date(nextTalk.start*1000);
			$lecture.find('.'+room)
				.find('.current-talk')
					.removeClass('hidden')
					.find('.t')
						.text(currentTalk.special ? 'none' : currentTalk.title)
					.end()
				.end()
				.find('.next-talk')
					.toggleClass('hidden', !nextTalk || nextTalk.special || (nextTalk.start - now > 60*60))
					.find('strong')
						.text(s.getHours()+':'+(s.getMinutes() < 10 ? '0' : '')+s.getMinutes())
					.end()
					.find('.t')
						.text(nextTalk ? nextTalk.title : '')
					.end()
				.end();
		});

		setTimeout(updateProgtamTeaser, updateTimer);
	}

	fetchProgram();
});


// feedback form
$(function() {
	$('.feedback-form').on('submit', function() {
		$('.feedback-form').hide();
		$('.feedback-thankyou').show();
	});
});
