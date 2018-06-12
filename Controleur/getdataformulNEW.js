var getdatafromurlNEW = function(myurl)
				{
				    var exist = null;
				    console.log("getdatafromurlNEW", myurl);
				    $.ajax({
				        url: myurl,
				        async: false,
				        success: function(result){
				            exist = result;
				        },
				        error: function(xhr){
				            console.log("error NEW", xhr);
				        }
				    });
				    return (exist);
				};