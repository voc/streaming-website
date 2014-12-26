$(function() {
	var
		$parent = $('.event-previews'),
		$loading = $parent,
		$tpl = $parent.find('.template').detach().removeClass('template');

	$.ajax({
		url: '/~peter/relive.json',
		success: function(els) {
			console.log(els);
			$loading.hide();
		}
	});
});