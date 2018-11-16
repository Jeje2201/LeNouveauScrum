/**
 * Active ou désactive le css sidenav-toggled quand clic ou non sur la navbar "gestion"
 */
$('#SlideNav').click(function () {
  $('body').toggleClass('sidenav-toggled');
});

/**
 *  Mettre la taille du select2 au max
 * @param {string} div Le div sur lequel jouer
 */
function SetSelect2(div) {
  $(div).select2({
    width: '100%'
  })
}
