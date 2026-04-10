/* offres.js */

document.addEventListener('DOMContentLoaded', function() {

    // Atténuer les autres cartes au survol d'une offre
    var cartes = document.querySelectorAll('.pricing-card');
    for (var i = 0; i < cartes.length; i++) {
        cartes[i].addEventListener('mouseenter', function() {
            for (var j = 0; j < cartes.length; j++) {
                if (cartes[j] !== this) {
                    cartes[j].style.opacity = '0.72';
                }
            }
        });
        cartes[i].addEventListener('mouseleave', function() {
            for (var k = 0; k < cartes.length; k++) {
                cartes[k].style.opacity = '';
            }
        });
    }

});
