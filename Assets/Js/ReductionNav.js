$('#SlideNav').click(function () {
  $('body').toggleClass('sidenav-toggled');
});

function SetSelect2(div) {
  $(div).select2({
    width: '100%'
  })
}