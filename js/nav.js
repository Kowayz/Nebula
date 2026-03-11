/* ============================================================
   nav.js — Navigation mobile + scroll effect
   ============================================================ */

(function () {
  'use strict';

  const navbar     = document.getElementById('navbar');
  const hamburger  = document.getElementById('hamburger');
  const navPanel   = document.getElementById('navPanel');
  const navOverlay = document.getElementById('navOverlay');

  // Scroll shadow
  if (navbar) {
    window.addEventListener('scroll', () => {
      navbar.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });
  }

  function closeMenu() {
    navPanel?.classList.remove('open');
    hamburger?.classList.remove('open');
    navOverlay?.classList.remove('open');
    hamburger?.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  function openMenu() {
    navPanel?.classList.add('open');
    hamburger?.classList.add('open');
    navOverlay?.classList.add('open');
    hamburger?.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  if (hamburger) {
    hamburger.addEventListener('click', () => {
      navPanel?.classList.contains('open') ? closeMenu() : openMenu();
    });
  }

  if (navOverlay) navOverlay.addEventListener('click', closeMenu);

  if (navPanel) {
    navPanel.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
  }

  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });
  window.addEventListener('resize', () => { if (window.innerWidth > 880) closeMenu(); }, { passive: true });
})();
