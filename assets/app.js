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


//--------- partie pour le switch du panel Admin ---------//
document.addEventListener('DOMContentLoaded', function() {
    const switchElements = document.querySelectorAll('input[id^=switch]');
    console.log(switchElements.length);
    const formElement = document.getElementById('banForm');
});
//--------- fin partie pour le switch du panel Admin ---------//



//--------- Partie de la barre de Recherche---------//

$(document).ready(function() {

    $('#live_search').keyup(function(){

      var input = $(this).val();
      if(input !=""){
        $.ajax({
            method: 'POST',
            url: 'service/recherche.php',
            data: {input:input},
            success: function(data){
                if(data !=""){
                    $('#result').html('');
                }else {
                    document.getElementById('result').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 20px'>Aucun événement</div>";
                }
            }
        })
      }


    });
});

