/* ============================================================
   catalogue.js — Filtres genre + recherche (jeux.php)
   ============================================================ */

(function () {
  'use strict';

  const filterBtns = document.querySelectorAll('.filter-btn');
  const searchInput = document.getElementById('searchInput');
  const cards = document.querySelectorAll('.catalogue-card');
  const noResults = document.getElementById('noResults');

  let activeGenre = 'tous';
  let searchTerm  = '';

  // ── Clic sur un filtre genre ────────────────────────────────
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeGenre = btn.dataset.genre || 'tous';
      applyFilters();
    });
  });

  // ── Recherche texte ─────────────────────────────────────────
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      searchTerm = searchInput.value.toLowerCase().trim();
      applyFilters();
    });
  }

  function applyFilters() {
    let visible = 0;

    cards.forEach(card => {
      const genre = (card.dataset.genre || '').toLowerCase();
      const title = (card.dataset.title || '').toLowerCase();

      const genreOk  = activeGenre === 'tous' || genre === activeGenre;
      const searchOk = searchTerm === '' || title.includes(searchTerm);

      if (genreOk && searchOk) {
        card.removeAttribute('hidden');
        visible++;
      } else {
        card.setAttribute('hidden', '');
      }
    });

    if (noResults) {
      noResults.style.display = visible === 0 ? 'block' : 'none';
    }
  }
})();
