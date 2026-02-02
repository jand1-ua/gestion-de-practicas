/*
  Frontend helpers (vanilla JS, sin dependencias externas)
  - Menú responsive
  - Filtros locales de tablas (búsqueda instantánea en el cliente)
*/

(function () {
  function initNavToggle() {
    const btn = document.querySelector('.nav-toggle');
    const nav = document.getElementById('app-nav');
    if (!btn || !nav) return;

    btn.addEventListener('click', function () {
      const isOpen = nav.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  function initTableFilters() {
    const inputs = document.querySelectorAll('[data-table-filter]');
    inputs.forEach(function (input) {
      const tableId = input.getAttribute('data-table-filter');
      if (!tableId) return;

      const table = document.getElementById(tableId);
      if (!table) return;

      const rows = Array.from(table.querySelectorAll('tbody tr'));

      input.addEventListener('input', function () {
        const q = (input.value || '').trim().toLowerCase();
        rows.forEach(function (row) {
          const text = (row.textContent || '').toLowerCase();
          row.style.display = text.indexOf(q) !== -1 ? '' : 'none';
        });
      });
    });
  }

  function initAutoFocus() {
    const el = document.querySelector('[data-autofocus]');
    if (el && typeof el.focus === 'function') el.focus();
  }

  document.addEventListener('DOMContentLoaded', function () {
    initNavToggle();
    initTableFilters();
    initAutoFocus();
  });
})();
