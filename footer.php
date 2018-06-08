<footer class="sticky-footer">
	<div class="container">
		<div class="text-center">
			Copyright © Ns Scrum 2018 - <i class="fa fa-github" aria-hidden="true">  </i><a target="_blank" href="https://github.com/Jeje2201/ScrumManager"> Projet Github</a> - <i class="fa fa-globe" aria-hidden="true"></i><a target="_blank" href="http://mrjeje.esy.es/">  Jérémy</a>
		</div>
	</div>
</footer>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fa fa-angle-up"></i>
</a>

<!-- Jquery JavaScript-->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap core JavaScript-->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- BootStrap pour les heures-->
<script src="js/bootstrap-datetimepicker.js"></script>
<script>

	var url = location.pathname.split("/")[2];
	$('nav a[href^="' + url + '"]')
	.closest('li')
	.addClass('active');
	
</script>