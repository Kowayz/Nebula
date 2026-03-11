/* ============================================================
   offres.js — FAQ accordion + interactions pricing
   ============================================================ */

(function () {
  'use strict';

  // ── Accordion FAQ ───────────────────────────────────────────
  document.querySelectorAll('.faq-question').forEach(q => {
    q.addEventListener('click', () => {
      const item    = q.closest('.faq-item');
      const wasOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
      if (!wasOpen) item.classList.add('open');
    });
  });

  // ── Mise en évidence du plan survolé ───────────────────────
  document.querySelectorAll('.pricing-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
      document.querySelectorAll('.pricing-card').forEach(c => {
        if (c !== card) c.style.opacity = '.72';
      });
    });
    card.addEventListener('mouseleave', () => {
      document.querySelectorAll('.pricing-card').forEach(c => {
        c.style.opacity = '';
      });
    });
  });
})();
