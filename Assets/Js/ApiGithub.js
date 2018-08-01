function GetAllVersionsInfos(Div) {

    var url = 'https://api.github.com/repos/Jeje2201/ScrumManager/releases?access_token=0d5e7ccbc3f3060289ad93eaac70b34cbeeca0a9';

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
               info += '<p><h3>'+DateSortie[2] +'-'+DateSortie[1] +'-'+DateSortie[0] +' (version '+data[a].tag_name+')</h3></p>'
               info += data[a].body
               info += ' <hr><br>'
               }
               }
           }


           $('#'+Div).html(info);
       }
   })
}

function CheckLatestVersionNumber() {

    var url = 'https://api.github.com/repos/Jeje2201/ScrumManager/releases/latest?access_token=0d5e7ccbc3f3060289ad93eaac70b34cbeeca0a9';
    // API request pour obtenir les infos de l'utilisateur et lui hacker sa base de donnée parceque nous bah on est des hackers d'abord
    $.ajax({
        url: url,
        success: function (data) {

          console.log('derniere version enregistré dans le pc: '+localStorage.getItem('DerniereVersionConnu')+ ' | derniere version release sur github: '+data.tag_name)

          if(localStorage.getItem('DerniereVersionConnu') == data.tag_name)
            document.getElementById("newsgithub").style.display = "none";
          else
            document.getElementById("newsgithub").style.display = "inline-block";
       }
   })

}

function SetLastVersion() {

    var url = 'https://api.github.com/repos/Jeje2201/ScrumManager/releases/latest?access_token=0d5e7ccbc3f3060289ad93eaac70b34cbeeca0a9';
    // API request pour obtenir les infos de l'utilisateur et lui hacker sa base de donnée parceque nous bah on est des hackers d'abord
    $.ajax({
        url: url,
        success: function (data) {
          if(localStorage.getItem('DerniereVersionConnu') != data.tag_name)
          localStorage.setItem('DerniereVersionConnu', data.tag_name);

       }
   })

}

