/* ============================================================
   configurateur.js — Real-time price calculator
   ============================================================ */

(function () {
  'use strict';

  /* ── DOM refs ─────────────────────────────────────────────── */
  const genreCheckboxes  = document.querySelectorAll('.genre-checkbox');
  const genreChips       = document.querySelectorAll('.genre-chip');
  const qualityRadios    = document.querySelectorAll('.quality-radio');
  const optionCheckboxes = document.querySelectorAll('.option-checkbox');

  const summaryGenres      = document.getElementById('summaryGenres');
  const summaryQualityName = document.getElementById('summaryQualityName');
  const summaryQualityPrice= document.getElementById('summaryQualityPrice');
  const summaryOptionsList = document.getElementById('summaryOptionsList');
  const summaryOptionsSection = document.getElementById('summaryOptionsSection');
  const summaryTotal       = document.getElementById('summaryTotal');

  /* Quality labels map */
  const qualityLabels = {
    hd:  'HD (720p)',
    fhd: 'Full HD (1080p)',
    '4k':'4K Ultra HD (2160p)',
  };

  /* Option labels map */
  const optionLabels = {
    raytracing:  'Ray Tracing',
    savecloud:   'Sauvegardes illimitées',
    support:     'Support prioritaire',
    multidevice: 'Multi-appareils',
  };

  /* ── Format price ─────────────────────────────────────────── */
  function fmt(num) {
    return num.toFixed(2).replace('.', ',') + ' €';
  }

  /* ── Recalculate & update sidebar ────────────────────────── */
  function update() {
    /* Genres */
    const selectedGenres = [...genreCheckboxes]
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    if (selectedGenres.length === 0) {
      summaryGenres.innerHTML = '<span class="summary-empty">Aucun genre sélectionné</span>';
    } else {
      summaryGenres.innerHTML = selectedGenres
        .map(g => `<span class="summary-genre-pill">${capitalise(g)}</span>`)
        .join('');
    }

    /* Quality */
    const activeQuality = document.querySelector('.quality-radio:checked');
    const qualityPrice  = activeQuality ? parseFloat(activeQuality.dataset.price) : 9.99;
    const qualityId     = activeQuality ? activeQuality.value : 'fhd';

    summaryQualityName.textContent  = qualityLabels[qualityId] ?? qualityId;
    summaryQualityPrice.textContent = fmt(qualityPrice);

    /* Options */
    const selectedOptions = [...optionCheckboxes].filter(cb => cb.checked);
    let optionsTotal = 0;

    if (selectedOptions.length === 0) {
      summaryOptionsSection.style.display = 'none';
      summaryOptionsList.innerHTML = '';
    } else {
      summaryOptionsSection.style.display = '';
      summaryOptionsList.innerHTML = selectedOptions.map(cb => {
        const price = parseFloat(cb.dataset.price);
        optionsTotal += price;
        const label = optionLabels[cb.value] ?? cb.value;
        return `<div class="summary-line">
          <span>${label}</span>
          <span>+${fmt(price)}</span>
        </div>`;
      }).join('');
    }

    /* Total */
    const total = qualityPrice + optionsTotal;
    summaryTotal.textContent = fmt(total);

    /* Animate total */
    summaryTotal.classList.remove('price-bump');
    void summaryTotal.offsetWidth; // reflow
    summaryTotal.classList.add('price-bump');
  }

  /* ── Chip toggle visual feedback ─────────────────────────── */
  genreCheckboxes.forEach((cb, i) => {
    cb.addEventListener('change', () => {
      genreChips[i].classList.toggle('selected', cb.checked);
      update();
    });
  });

  /* ── Quality radio ────────────────────────────────────────── */
  qualityRadios.forEach(radio => {
    radio.addEventListener('change', update);
  });

  /* ── Options checkboxes ───────────────────────────────────── */
  optionCheckboxes.forEach(cb => {
    cb.addEventListener('change', update);
  });

  /* ── Utilities ────────────────────────────────────────────── */
  function capitalise(str) {
    if (!str) return str;
    return str.charAt(0).toUpperCase() + str.slice(1);
  }

  /* ── Init: run once to set correct default state ─────────── */
  update();

})();
