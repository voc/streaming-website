// mediaelement-player
$(function() {
	(function(strings) {
		strings['en-US'] = {
			'Download File': 'Open Stream in Desktop-Player'
		}
	})(mejs.i18n.locale.strings);

	var feat = ['playpause', 'volume', 'fullscreen'];
	if($('.video-wrap').hasClass('has-subtitles'))
		feat.push('subtitles');

	$('body.room video, body.embed video').mediaelementplayer({
		features: feat,
		enableAutosize: true
	});

	$('body.room audio, body.embed audio').mediaelementplayer({
		features: ['playpause', 'volume', 'current']
	});

	$('body.relive-player video').mediaelementplayer({
		mode: 'auto_plugin',
		plugins: ['flash'],
		flashName: 'flashmediaelement.swf',
		pluginPath: '../assets/mejs/',
		enableAutosize: true,
		success: function (mediaElement) {
			mediaElement.addEventListener('canplay', function () {
				// skip forward to scheduled beginning of the talk at ~ 0:14:30  (30 sec offset, if speaker starts on time)
				if ( mediaElement.currentTime == 0 ) {
					mediaElement.setCurrentTime(870);
				}
			})
		}
	});

	$(window).on('load', function() {
		$(window).trigger('resize');
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

// schedule-timeline
$(function() {
	var
		$schedule = $('body .schedule'),
		$now = $schedule.find('.now'),
		scrollLock = false,
		rewindTimeout,

		/* 10 seconds after manual navigation */
		rewindTime = 10000,

		/* 1/2s animation on the scolling element */
		scrollDuration = 500,

		/* update now-pointer placement every 1/2s */
		updateTimer = 500,

		/* offset to the browsers realtime (for simulation) */
		offset = $('.js-schedule-settings').data('scheduleoffset');

	$schedule.on('mouseenter mouseleave touchstart touchend', function(e) {
		if(e.type == 'mouseleave' || e.type == 'touchend') {
			rewindTimeout = setTimeout(function() {
				scrollLock = false;
			}, 5000);
		} else {
			clearTimeout(rewindTimeout);
			scrollLock = true;
		}
	});

	// schedule now-marker & scrolling
	function updateProgramView(initial) {
		var
			// corrected "now" timestamp in unix-counting (seconds, not microseconds)
			now = (Date.now() / 1000) + offset;

		// only check the first room (shouldn't matter anyway)
		// find the newest block that starts in the past
		// that's the one that is most probably currently still running
		var $block = $schedule
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

			// projected to pixels with respect to the schedules left end
			px = $block.position().left + ($block.outerWidth() * normalized),

			// visible width of the schedule display
			displayw = $schedule.width(),

			// current scroll position
			scrollx = $schedule.scrollLeft(),

			// distance of the now-marker to the left border of the schedule display
			px_in_display = px - scrollx;

		//console.log($block.get(0), new Date(start*1000), new Date(now*1000), new Date(end*1000), normalized, px);
		$now.css('width', px);

		// scrolling is locked by manual interaction
		if(scrollLock)
			return;

		if(
			// now marker is > 2/3 of the schedule-display-width
			px_in_display > (displayw * 2/3) || 

			// now marker is <1/7 of the schedule-display-width
			px_in_display < (displayw/7)
		) {
			// scroll schedule so that now-marker is as 1/5 of the screen
			$schedule.stop().scrollTo(px - displayw/6, {
				axis: 'x',
				duration: initial ? 0 : scrollDuration,
			});
		}
	}


	// when on schedules tab
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

	if(window.location.hash == '#schedule' || window.location.href.indexOf('/schedule') != -1)
		on();

	// trigger when a tab was changed
	$('.nav-tabs').on('shown.bs.tab', 'a', function(e) {
		if(e.target.hash == '#schedule')
			on();
		else
			off();
	});
});

// feedback form
$(function() {
	$('.feedback-form').on('submit', function(e) {
		e.preventDefault();
		var $form = $(this);

		$('.feedback-form').hide();
		$.ajax({
			url: $form.prop('action'),
			method: $form.prop('method'),
			data: $form.serialize(),
			success: function() {
				$('.feedback-thankyou').show();
			},
			error: function() {
				$('.feedback-error').show();
			}
		});

	});
});

// update teaser images
$(function() {
	setInterval(function() {
		$('.rooms .lecture .teaser').each(function() {
			var
				$teaser = $(this),
				$preload = $('<img />'),
				src = $teaser.data('src');

			if(!src) {
				src = $teaser.prop('src');
				$teaser.data('src', src);
			}

			$preload.on('load', function() {
				$teaser.prop('src', $preload.prop('src'));
			}).prop('src', src + '?'+(new Date()).getTime());
		});
	}, 1000*60);
});

// multiviewer
$(function() {
	var audioMeter = !!window.chrome;
	$('body.multiview')
		.find('audio, video')
			.each(function(idx, player) {

				var
					$player = $(player),
					$meter = $player.closest('.cell').find('.meter'),
					$timer = $player.closest('.cell').find('.timer');

				$player.on("timeupdate", function(e)
				{
					var
						s = Math.floor(this.currentTime % 60),
						m = Math.floor(this.currentTime / 60) % 60,
						h = Math.floor(this.currentTime / 60 / 60) % 24,
						d = Math.floor(this.currentTime / 60 / 60 / 24),
						f = Math.floor((this.currentTime - Math.floor(this.currentTime)) * 1000),
						txt = '';

					txt += d+'d ';

					if(h < 10) txt += '0';
					txt += h+'h ';

					if(m < 10) txt += '0';
					txt += m+'m ';

					if(s < 10) txt += '0';
					txt += s+'s ';

					if(f < 10) txt += '00';
					else if(f < 100) txt += '0';
					txt += f+'ms';

					$timer.text(txt);
				});

				if(!audioMeter)
				{
					$player.prop('muted', true);
					$meter.hide();
					return;
				}

				var
					ctx = new AudioContext(),
					audioSrc = ctx.createMediaElementSource(player),
					analyser = ctx.createAnalyser();

				// we have to connect the MediaElementSource with the analyser 
				audioSrc.connect(analyser);

				// we could configure the analyser: e.g. analyser.fftSize (for further infos read the spec)
				analyser.fftSize = 64;

				var w = 100 / analyser.frequencyBinCount;
				for (var i = 0; i < analyser.frequencyBinCount; i++) {
					var c = Math.floor( i * 255 / analyser.frequencyBinCount );
					$('<div class="bar">')
						.css({
							'width': w+'%',
							'left': (i*w)+'%',
							'background-color': 'rgb('+c+', '+(192 - c)+', 0)'
						})
						.appendTo($meter);
				}

				var $bars = $meter.find('.bar');

				// frequencyBinCount tells you how many values you'll receive from the analyser
				var frequencyData = new Uint8Array(analyser.frequencyBinCount);

				// we're ready to receive some data!
				function renderFrame() {
					// update data in frequencyData
					analyser.getByteFrequencyData(frequencyData);
					// render frame based on values in frequencyData

					for (var i = 0; i < frequencyData.length; i++) {
						$($bars[i]).css('height', frequencyData[i] / 255 * 40);
					}

					// loop
					requestAnimationFrame(renderFrame);
				}
				renderFrame();
			});
});

// embed-form
$(function() {
	var originalsrc;
	$('.embed-form #size, .embed-form #autoplay').on('click', function() {
		var
			$size = $('.embed-form #size'),
			selected = $size.val().split(','),
			$size = $('.embed-form #size'),
			$codefield = $('#embed-code'),
			$urlfield = $('#embed-url'),
			$iframe = $( $codefield.val() ),
			autoplay = $('.embed-form #autoplay').prop('checked');

		if(!originalsrc)
			originalsrc = $iframe.attr('src');

		var src = originalsrc + (autoplay ? '' : 'no-autoplay/');

		$iframe.attr({width: selected[0], height: selected[1]});
		$iframe.attr({src: src});

		$codefield.val( $iframe.prop('outerHTML') );
		$urlfield.val( src );
	})

	$('.embed-form').on('click', 'input[type=text]', function() {
		$(this).select();
	});
});
