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
            for (var i = 0; i < data.length; i++) {
                DateSortie = data[i].published_at.split('T')[0].split('-')
               info += '<p><b>'+ data[i].name + ' </b>( Sortie le: '+DateSortie[2] +'-'+DateSortie[1] +'-'+DateSortie[0] +' )</p>'
               info += data[i].body
               info += ' <hr><br>'
           }

           $('#'+Div).html(info);
       }
   })
}