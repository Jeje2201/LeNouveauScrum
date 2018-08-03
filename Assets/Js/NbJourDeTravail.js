function NbJourDeTravail(DateDebut, DateFin){

    if(DateDebut.split('-')[0].length != 4)
    start = new Date(DateDebut.split('-')[2]+'-'+DateDebut.split('-')[1]+'-'+DateDebut.split('-')[0])
    else
	start = new Date(DateDebut)

	if(DateFin.split('-')[0].length != 4 )
	end = new Date(DateFin.split('-')[2]+'-'+DateFin.split('-')[1]+'-'+DateFin.split('-')[0])
	else
	end = new Date(DateFin)

    var NbHeureAttribuableMax = 0;

    if(start > end)
    	return -1
    else{
    while (start <= end) {
      var day = start.getDay();
      
      if (day != 0 && day != 6)
       NbHeureAttribuableMax += 1

      start.setDate(start.getDate() + 1);
    }
    return NbHeureAttribuableMax;
    }

    

}