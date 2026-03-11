/* ============================================================
   auth.js — Tab switching + password toggle + validation
   ============================================================ */

(function () {
  'use strict';

  const card = document.querySelector('.auth-card');
  if (!card) return;

  const tabs   = card.querySelectorAll('.auth-tab[data-tab]');
  const panels = card.querySelectorAll('.auth-panel');

  /* ── Activation d'un onglet ────────────────────────────────── */
  function switchTab(name) {
    tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === name));
    panels.forEach(p => p.classList.toggle('active', p.id === 'panel-' + name));
    history.replaceState(null, '', '?tab=' + name);
  }

  /* ── Init : onglet défini par PHP ───────────────────────────── */
  switchTab(card.dataset.initialTab || 'login');

  /* ── Liens "Créer un compte" / "Se connecter" dans le footer ── */
  card.querySelectorAll('[data-switch-tab]').forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      switchTab(link.dataset.switchTab);
    });
  });

  /* ── Toggle visibilité mot de passe ────────────────────────── */
  card.querySelectorAll('.input-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.input-wrapper').querySelector('input');
      if (!input) return;
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.textContent = show ? '🙈' : '👁';
      btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
    });
  });

  /* ── Validation register ───────────────────────────────────── */
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', (e) => {
      registerForm.querySelectorAll('.form-error').forEach(el => el.remove());

      const pwd  = document.getElementById('reg-password');
      const conf = document.getElementById('reg-password-confirm');

      if (pwd.value.length < 8) {
        e.preventDefault();
        showError(pwd, 'Le mot de passe doit contenir au moins 8 caractères.');
        return;
      }
      if (pwd.value !== conf.value) {
        e.preventDefault();
        showError(conf, 'Les mots de passe ne correspondent pas.');
      }
    });
  }

  function showError(input, message) {
    const err = document.createElement('p');
    err.className = 'form-error';
    err.textContent = message;
    input.closest('.form-group').appendChild(err);
  }

})();
