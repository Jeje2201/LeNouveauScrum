	var sPageURL = window.location.search.substring(1).split('=');
	$('nav a[href^="index.php?vue=' + sPageURL[1] + '"]').closest('li').addClass('active');