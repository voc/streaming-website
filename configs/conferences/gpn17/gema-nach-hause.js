function handleLoungeStreamWhichActuallyDoesNotExist()
{
	function gema1() {
		$('#gemaModal1')
			.modal()
			.find('.btn[data-gema=yes]').on('click', function() {
				$('#gemaModal1').modal('hide')
				gema3();
			})
			.end()
			.find('.btn[data-gema=no]').on('click', function() {
				$('#gemaModal1').modal('hide')
				gema2();
			})
	}

	function gema2() {
		$('#gemaModal2')
			.modal()
			.find('.btn').on('click', function() {
				$('#gemaModal2').modal('hide')
				gema3();
			})
	}

	function gema3() {
		$('#gemaModal3').modal()
	}

	$('.room-lounge a').on('click', function(e) {
		e.preventDefault();
		gema1();
	});
}

$(handleLoungeStreamWhichActuallyDoesNotExist);
