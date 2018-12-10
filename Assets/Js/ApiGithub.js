/**
 * Permet d'obtenir toutes les version qui sont présentes sur Github et les lister 
 * @param {string} Div Représente le div dans lequel sera le tableau avec toutes les version 
 */
function GetAllVersionsInfos(Div) {

    var url = 'https://api.github.com/repos/Jeje2201/ScrumManager/releases?access_token=0d5e7ccbc3f3060289ad93eaac70b34cbeeca0a9';

    //par checker les version
    $.ajax({
        url: url,
        statusCode: {
            403: function () {
                alert("Mhm.. Manque internet ? Car problème de connexion à l'api de Github..");
            }
        },

        //Si réussi
        success: function (data) {
            var info = "";
            var liste = []

            //Faire un array avec toutes les version
            for (var i = 0; i < data.length; i++) {
                tag = parseFloat(data[i].tag_name)
                liste.push(tag)
            }

            //trier l'array dans l'ordre de numero de version
            liste.sort(function (a, b) {
                return b - a
            })

            //pour numéro de version dans la liste, récupérer les changelog associés dans de l'html
            for (var i = 0; i < liste.length; i++) {

                tag = liste[i]

                for (var a = 0; a < liste.length; a++) {
                    if (tag == parseFloat(data[a].tag_name)) {
                        Version = data[a].name + '  (' + data[a].published_at.split('T')[0].split('-')[2] + '-' + data[a].published_at.split('T')[0].split('-')[1] + '-' + data[a].published_at.split('T')[0].split('-')[0] + ')'

                        info += '   <div class="panel-group" id="faqAccordion">\
                                        <div class="panel panel-default ">\
                                            <div class="panel-heading accordion-toggle question-toggle collapsed" data-toggle="collapse" data-parent="#faqAccordion"              data-target="#question'+ a + '">\
                                                <h4 class="panel-title"><a href="#" class="ing" style="color:#917a7a">'+ Version + '</a></h4>\
                                            </div>\
                                            <div id="question'+ a + '" class="panel-collapse collapse" style="height: 0px;">\
                                                <div class="panel-body">'+  data[a].body.replace(/\*/g,'</li><li>') + '</div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <hr>'

                    }
                }
            }
            //renvoyer le tout dans la div passé en argument
            $('#' + Div).html(info);
        }
    })
}

/**
 * Fonction pour checker la dernier version, et si n'est pas à jour, afficher le label rouge "news" a coté de changelog dans la navbar
 */
function CheckLatestVersionNumber() {

    var url = 'https://api.github.com/repos/Jeje2201/ScrumManager/releases/latest?access_token=0d5e7ccbc3f3060289ad93eaac70b34cbeeca0a9';

    $.ajax({
        url: url,
        success: function (data) {

            console.log('Current version: ' + localStorage.getItem('DerniereVersionConnu') + ' | Last version found: ' + data.tag_name)

            if (localStorage.getItem('DerniereVersionConnu') == data.tag_name)
                document.getElementById("newsgithub").style.display = "none";
            else
                document.getElementById("newsgithub").style.display = "inline-block";
        }
    })

}

/**
 * Fonction pour set la derniere version dans le cache de la session google
 */
function SetLastVersion() {

    var url = 'https://api.github.com/repos/Jeje2201/ScrumManager/releases/latest?access_token=0d5e7ccbc3f3060289ad93eaac70b34cbeeca0a9';
    $.ajax({
        url: url,
        success: function (data) {
            //si quand je check les changelog, ma derniere version dans le cache de google n'est pas la meme que celle sur github, dire a mon cache que j'ai regardé la derniere version et donc que je suis à jour avec les derniers news 
            if (localStorage.getItem('DerniereVersionConnu') != data.tag_name)
                localStorage.setItem('DerniereVersionConnu', data.tag_name);

        }
    })

}