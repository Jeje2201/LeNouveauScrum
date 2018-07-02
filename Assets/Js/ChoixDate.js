function ChoixDate(jours){

      if(jours == null){
        var jours = 14;
      }
      else{
        jours = parseInt(jours);
      }

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

      return a + "-" + m + "-" + j;
      
    };