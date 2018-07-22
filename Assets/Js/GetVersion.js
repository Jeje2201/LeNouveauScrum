function GetLatestVersion(Div) {

    var url = 'https://api.github.com/repos/Jeje2201/ScrumManager/releases';

    // API request pour obtenir les infos de l'utilisateur et lui hacker sa base de donnée parceque nous bah on est des hackers d'abord
    $.ajax({
        url: url,
        statusCode: {
            403: function () {
                alert("Mhm.. problème de connexion à l'api de Github..");
            }
        },
        success: function (data) {

            var info = "";
            var liste = []
            for (var i = 0; i < data.length; i++) {
                liste.push(data[i].tag_name)

           }
           liste.sort()
           liste.reverse()
           console.log('taille liste version: '+liste.length)
           console.log(liste)

          for (var i = 0; i < liste.length; i++) {

               tag = liste[i]

               for (var a = 0; a < liste.length; a++) {
                  if(tag == parseInt(data[a].tag_name) ){
                    console.log('trouvé: '+data[a].tag_name)
                  
                DateSortie = data[a].published_at.split('T')[0].split('-')
               info += '<p><b>'+ data[a].name + ' </b>( Sortie le: '+DateSortie[2] +'-'+DateSortie[1] +'-'+DateSortie[0] +' )</p>'
               info += data[a].body
               info += ' <hr><br>'
               }
               }
           }


           $('#'+Div).html(info);
       }
   })
}