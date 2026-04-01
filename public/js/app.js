/*
  Frontend helpers (vanilla JS, sin dependencias externas)
  - Menú responsive
  - Autofocus contextual
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

  function initAutoFocus() {
    const el = document.querySelector('[data-autofocus]');
    if (el && typeof el.focus === 'function') el.focus();
  }

  document.addEventListener('DOMContentLoaded', function () {
    initNavToggle();
    initAutoFocus();
  });
})();
