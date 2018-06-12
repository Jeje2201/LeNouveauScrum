	var url = location.pathname.split("/")[3];
	$('nav a[href^="' + url + '"]')
	.closest('li')
	.addClass('active');