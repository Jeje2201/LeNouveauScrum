	var url = location.pathname.split("/")[2];
	$('nav a[href^="' + url + '"]')
	.closest('li')
	.addClass('active');