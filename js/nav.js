// nav.js — Navigation mobile et effet de scroll

document.addEventListener('DOMContentLoaded', function() {

    var navbar    = document.getElementById('navbar');
    var hamburger = document.getElementById('hamburger');
    var navPanel  = document.getElementById('navPanel');
    var overlay   = document.getElementById('navOverlay');

    // Ajouter une ombre à la navbar quand on scrolle vers le bas
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    function fermerMenu() {
        if (navPanel)   navPanel.classList.remove('open');
        if (hamburger)  hamburger.classList.remove('open');
        if (overlay)    overlay.classList.remove('open');
        if (hamburger)  hamburger.setAttribute('aria-expanded', 'false');
        // Rendre le scroll de la page à nouveau possible
        document.body.style.overflow = '';
    }

    function ouvrirMenu() {
        if (navPanel)   navPanel.classList.add('open');
        if (hamburger)  hamburger.classList.add('open');
        if (overlay)    overlay.classList.add('open');
        if (hamburger)  hamburger.setAttribute('aria-expanded', 'true');
        // Bloquer le scroll de la page derrière le menu
        document.body.style.overflow = 'hidden';
    }

    if (hamburger) {
        hamburger.addEventListener('click', function() {
            if (navPanel && navPanel.classList.contains('open')) {
                fermerMenu();
            } else {
                ouvrirMenu();
            }
        });
    }

    // Cliquer sur l'overlay (fond sombre) ferme le menu
    if (overlay) {
        overlay.addEventListener('click', fermerMenu);
    }

    // Cliquer sur un lien du menu le ferme
    if (navPanel) {
        var liens = navPanel.querySelectorAll('a');
        for (var i = 0; i < liens.length; i++) {
            liens[i].addEventListener('click', fermerMenu);
        }
    }

    // Touche Echap pour fermer le menu
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') fermerMenu();
    });

    // Fermer automatiquement si on repasse en vue desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 880) fermerMenu();
    });
});
