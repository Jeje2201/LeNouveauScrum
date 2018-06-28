function BootstrapAlert(message){
    $('#myModal').modal('show');
    $('#InterieurDeLalert').text(message);
    setTimeout(function(){
    $('#myModal').modal('hide');
},  parseInt(localStorage.getItem('TempsAffichagePopup')));
  }