	var sPageURL = window.location.search.substring(1).split('=');

	$( "li" ).each(function() {
		$( this ).removeClass( "active" );
	});
	
	$('nav a[href^="index.php?vue=' + sPageURL[1] + '"]').closest('li').addClass('active');