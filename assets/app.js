/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// code tarteaucitron
import './tarteaucitron';

// START ALERTS
const alerts = document.querySelectorAll('[role="alert"]') // on récupère tous les éléments avec l'attribut role="alert"
for (const alert of alerts) { // pour chaque élément
    setTimeout( function() { // on attend 5 secondes
        const bootstrapAlert = bootstrap.Alert.getOrCreateInstance(alert);
        bootstrapAlert.close(); // on ferme l'alerte
    }, 5000);
}
// STOP ALERTS

//--------- partie pour le switch du panel Admin pour ban un user ---------//
document.addEventListener('DOMContentLoaded', function() {
    const switchElements = document.querySelectorAll('input[id^=switch]');
    console.log(switchElements.length);
    const formElement = document.getElementById('banForm');
});

//--------- partie pour le switch du panel Admin pour lock un event ---------//

document.addEventListener('DOMContentLoaded', function() {
    const switchElements = document.querySelectorAll('input[id^=switch]');
    console.log(switchElements.length);
    const formElement = document.getElementById('lockForm');
});

//--------- Partie de la barre de Recherche---------//
var multimediaEventRoute = "/multimedia/event/";

$(document).ready(function() {

    $('#live_search').keyup(function(){

        var input = $(this).val();
        // alert(input);

        if(input != ""){
            $.ajax({

                method: 'GET',
                url: '/events/search',
                data: {searchTerm:input},

                success: function(data){

                    var result = data.results || data;
                    console.log(result);
                    var resultHtml = "";

                    for(var i = 0; i < result.length; i++){
                        resultHtml += "<a href=" + multimediaEventRoute + result[i].id + "><p>" + result[i].name + "</p></a>"
                    }

                    $('#result').html(resultHtml);
                    $('#result').css('display', 'block');
                }
            });
        } else {
            $('#result').css('display', 'none');
        }
    });
});

// $(document).ready(function() {

//     $('#name_search').keyup(function(){

//         var input = $(this).val();
//         // alert(input);

//         if(input != ""){
//             $.ajax({

//                 method: 'GET',
//                 url: '/events/search',
//                 data: {data:input},

//                 success: function(data){
// console.log(data);
//                     var result = data.results || data;

//                     var resultHtml = "";

//                     for(var i = 0; i < result.length; i++){
//                         resultHtml += "<div>" + result[i].name + "</div>"
//                     }

//                     $('#result').html(resultHtml);
//                     $('#result').css('display', 'block');
//                 }
//             });
//         } else {
//             $('#result').css('display', 'none');
//         }
//     });
// });


