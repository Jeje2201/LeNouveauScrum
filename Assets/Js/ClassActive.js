function ClassActive(LaPage){

	$( "li" ).each(function() {
		$( this ).removeClass( "active" );
	});
	
	$('nav a[href^="index.php?vue=' + LaPage + '"]').closest('li').addClass('active');
}

