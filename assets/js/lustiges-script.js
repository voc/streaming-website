// mediaelement-player
$(function() {
	function deserialize(string) {
	  var result = {};
	  if (string) {
	    var parts = string.split(/&|\?/);
	    for (var i = 0; i < parts.length; i++) {
	      var part = parts[i].split("=");
	      if (part.length === 2)
	        result[decodeURIComponent(part[0])] = decodeURIComponent(part[1]);
	    }
	  }
	  return result;
	}

	(function(strings) {
		strings['en-US'] = {
			'Download File': 'Open Stream in Desktop-Player'
		}
	})(mejs.i18n.locale.strings);

	var feat = ['playpause', 'volume', 'fullscreen'];
	if($('.video-wrap').hasClass('has-subtitles'))
		feat.push('subtitles');

	$('body.room video.mejs, body.embed video.mejs').mediaelementplayer({
		features: feat,
		enableAutosize: true
	});

	$('body.room audio.mejs, body.embed audio.mejs').mediaelementplayer({
		features: ['playpause', 'volume', 'current']
	});

	var $player = $('.video-wrap[data-voc-player]');
	if ($player.length > 0) {
		var config = {
			parent: $player.get(0),
			plugins: [],
			baseUrl: 'assets/voc-player/',
			autoPlay: true,
			poster: $player.data("poster"),
			audioOnly: !!$player.data("audio-only"),
			h264Only: !!$player.data("h264-only"),
			preferredAudioLanguage: $player.data("preferred-language"),
			events: {
				onReady: function() {
					var player = this;
					var playback = player.core.getCurrentContainer().playback;
					var params = deserialize(location.href)

					playback.once(Clappr.Events.PLAYBACK_PLAY, function() {

						// Allow custom skip via URL
						var seek = parseFloat(params.t);
						if (!isNaN(seek)) {
							player.seek(seek);

						// skip forward to scheduled beginning of the talk at
						// ~ 0:14:30  (30 sec offset, if speaker starts on time)
						} else if (playback.getPlaybackType() == 'vod') {
							player.seek(15 * 60);
						}
					});
				}
			}
		}

		// Select source
		if ($player.data("stream")) {
			config.vocStream = $player.data("stream");
		} else if ($player.data("source")) {
			config.source = $player.data('source');
			config.playbackRateConfig = {
				defaultValue: 1,
				options: [
				  {value: 0.75, label: '0.75x'},
				  {value: 1, label: '1x'},
				  {value: 1.25, label: '1.25x'},
				  {value: 1.5, label: '1.5x'},
				  {value: 2, label: '2x'},
				],
			};
			config.plugins.push(PlaybackRatePlugin);
		}

		// Show timeline previews if present
		if ($player.data("sprites")) {
			var sprites = ClapprThumbnailsPlugin.buildSpriteConfig(
				$player.data("sprites"),
				$player.data("sprites-n"),
				160, 90,
				$player.data("sprites-cols"),
				$player.data("sprites-interval")
			);
			config.plugins.push(ClapprThumbnailsPlugin);
			config.scrubThumbnails = {
				backdropHeight: 64,
				spotlightHeight: 84,
				thumbs: sprites
			};
		}
		new VOCPlayer.Player(config);
	}

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
		$time = $('.navbar-time'),
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

	function formatLocalTime(timestamp, offset) {
		const d = new Date(timestamp * 1000);

		// js timezone offset is negative
		const diff = -d.getTimezoneOffset() - offset;
		d.setUTCMinutes(d.getUTCMinutes() - diff);

		return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
	}

	function formatOffset(offset) {
		const sign = offset < 0 ? "-" : "+";
		const hours = String(Math.floor(Math.abs(offset)/60)).padStart(2, '0');
		const minutes = String(Math.abs(offset)%60).padStart(2, '0');
		return sign + hours + ":" + minutes;
	}

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

		// if we are yet to start find first block as reference
		if (!$block.length)
			$block = $schedule
				.find('.room').first()
				.find('.block').first();

		// still no luck
		if(!$block.length) {
			$now.find('.overlay').css('width', 0);
			$now.find('.label').text('now');
			return;
		}

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
		const eventOffset = parseFloat($block.data('offset')) || 0;
		const eventTime = formatLocalTime(now, eventOffset);
		$now.find('.overlay').css('width', px);
		$now.find('.label').text("now (" + eventTime + ")");
		$time.text(eventTime + " (" + formatOffset(eventOffset) + ")");

		// scrolling is locked by manual interaction
		if (scrollLock)
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

	if(window.location.hash == '' || window.location.hash == '#schedule' || window.location.href.indexOf('/schedule') != -1)
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

		var src = originalsrc;
		if (! autoplay) {
			if (src.slice(-1) !== '/') {
			src += '/';
			}
			src += 'no-autoplay'
		}

		$iframe.attr({width: selected[0], height: selected[1]});
		$iframe.attr({src: src});

		$codefield.val( $iframe.prop('outerHTML') );
		$urlfield.val( src );
	})

	$('.embed-form').on('click', 'input[type=text]', function() {
		$(this).select();
	});
});
