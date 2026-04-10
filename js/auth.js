/* auth.js */

document.addEventListener('DOMContentLoaded', function() {

    // Boutons pour afficher/cacher le mot de passe
    var bascules = document.querySelectorAll('.input-toggle');
    for (var i = 0; i < bascules.length; i++) {
        bascules[i].addEventListener('click', function() {
            var champ = this.closest('.input-wrapper').querySelector('input');
            if (!champ) return;
            if (champ.type === 'password') {
                champ.type = 'text';
                this.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
            } else {
                champ.type = 'password';
                this.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>';
            }
        });
    }

    // Validation du formulaire d'inscription avant envoi
    var formulaire = document.getElementById('registerForm');
    if (formulaire) {
        formulaire.addEventListener('submit', function(e) {
            var anciennesErreurs = formulaire.querySelectorAll('.form-error');
            for (var j = 0; j < anciennesErreurs.length; j++) {
                anciennesErreurs[j].remove();
            }

            var mdp     = document.getElementById('reg-password');
            var mdpConf = document.getElementById('reg-password-confirm');

            if (mdp.value.length < 8) {
                e.preventDefault();
                var err1 = document.createElement('p');
                err1.className = 'form-error';
                err1.textContent = 'Le mot de passe doit contenir au moins 8 caractères.';
                mdp.closest('.form-group').appendChild(err1);
                return;
            }
            if (mdp.value !== mdpConf.value) {
                e.preventDefault();
                var err2 = document.createElement('p');
                err2.className = 'form-error';
                err2.textContent = 'Les mots de passe ne correspondent pas.';
                mdpConf.closest('.form-group').appendChild(err2);
            }
        });
    }

});
