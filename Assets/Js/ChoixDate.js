function ChoixDate(_id,jours){

      if(jours == null){
        var jours = 14;
      }
      else{
        jours = parseInt(jours);
      }

      var _dat = document.querySelector(_id);
      var Apres = new Date();
      Apres.setDate(Apres.getDate()+jours);
      j = Apres.getDate(),
      m = Apres.getMonth()+1, 
      a = Apres.getFullYear();

      if(j < 10){
        j = "0" + j;
      };
      if(m < 10){
        m = "0" + m;
      };

      _dat.value = a + "-" + m + "-" + j;
      
    };