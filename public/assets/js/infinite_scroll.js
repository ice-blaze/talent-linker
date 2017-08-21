$(function() {
	$('ul.pagination').hide();
	$('.card-deck-wrapper').jscroll({
		autoTrigger: true,
		loadingHtml: '<img class="center-block" src="" alt="Loading..." />',
		padding: 0,
		nextSelector: '.pagination li.active + li a',
		contentSelector: 'div.card-deck-wrapper',
		callback: function() {
			$('ul.pagination').remove();
		}
	});
});
