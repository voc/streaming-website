MediaElementPlayer.prototype.buildsubtitles = function(player, controls, layers, media) {
	var $btns = $([
		'<span>',
			'<div class="mejs-button mejs-subtitles mejs-subtitles-button">',
				'<button type="button" title="Subtitles" aria-label="Subtitles"></button>',
			'</div>',
			'<div class="mejs-button mejs-subtitles mejs-subtitles-popup-button">',
				'<button type="button" title="Subtitles in Popup" aria-label="Subtitles in Popup"></button>',
			'</div>',
		'</span>'
	].join(''));

	$btns
		.appendTo(controls)
		.on('click', '.mejs-subtitles-button', function() {
			var $lines = $('.mejs-subtitles-lines');
			if($lines.is(':visible'))
			{
				//console.log('hiding lines');
				$lines.css({
					display: 'none'
				});
			}
			else
			{
				connectToL2S2()
			}
		})
		.on('click', '.mejs-subtitles-popup-button', function() {
			var
				frontend_url = $('.js-subtitles-settings').data('frontend-url'),
				room = $('.video-wrap').data('subtitles-room-id');

			window.open(frontend_url+''+room, 'subtitles-'+room, 'width=1000,height=560');
		});


	var	$lines = $([
		'<div class="mejs-subtitles-lines">',
			'<div class="mejs-subtitles-lines-inner"></div>',
		'</div>'
	].join(''));

	$lines.appendTo(layers);
};

function connectToL2S2()
{
	var
		baseurl = $('.js-subtitles-settings').data('primus-url'),
		$lines = $('.mejs-subtitles-lines');

	if(window.Primus)
	{
		if(window.primus_connection)
		{
			//console.log('showing lines');

			$lines.css({
				display: 'block'
			});
		}
		else
		{
			openSocket();
		}
	}
	else
	{
		//console.log('loading primus.js');
		$.getScript(baseurl+'primus/primus.js', openSocket);
	}
}

function openSocket()
{
	if(window.primus_connection)
	{
		return;
	}

	var
		baseurl = $('.js-subtitles-settings').data('primus-url'),
		room = $('.video-wrap').data('subtitles-room-id'),
		$lines = $('.mejs-subtitles-lines');

	//console.log('connecting to primus server');
	var primus = Primus.connect(baseurl);
	window.primus_connection = primus;

	primus.on('open', function()
	{
		primus.emit('join', room);

		//console.log('showing lines');
		$lines.css({
			display: 'block'
		});
	});

	// primus.on('lineStart', function(roomId, userId, text)
	// {
	// 	console.log('lineStart', roomId, userId, text);
	// });

	primus.on('line', function(roomId, text, userId, color)
	{
		if (text && text.trim().length > 0 && roomId == room) {
			//console.log('line', roomId, userId, text, color);
			appendLine(text);
		}
	});
}

function appendLine(line)
{
	var
		$inner = $('.mejs-subtitles-lines .mejs-subtitles-lines-inner'),
		$line = $('<div>').text(line),
		cnt = 3;

	$inner
		.append($line)
		.find('> div')
		.slice(0, -cnt)
		.remove()


	$line.autoScale();
}




$.fn.autoScale = function() {
	if(!this.data('autoScaleOriginal')) {
		this.data('autoScaleOriginal', parseInt(this.css('font-size')));
	}

	var
		maxSize = this.data('autoScaleOriginal');
		maxH = this.closest('.mejs-subtitles-lines').innerHeight(),
		thisH = this.css('font-size', maxSize).outerHeight();

	//console.log(thisH, maxH, maxSize);
	while(thisH > maxH && maxSize > 0) {
		//console.log(thisH, maxH, maxSize);
		thisH = this.css('font-size', --maxSize).outerHeight();
	}

	return this;
}
