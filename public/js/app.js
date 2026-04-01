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

  function getStoredTheme() {
    try {
      const theme = window.localStorage.getItem('practua-theme');
      return theme === 'light' || theme === 'dark' ? theme : 'dark';
    } catch (error) {
      return 'dark';
    }
  }

  function persistTheme(theme) {
    try {
      window.localStorage.setItem('practua-theme', theme);
    } catch (error) {
      // noop
    }
  }

  function applyTheme(theme, button) {
    const root = document.documentElement;
    const currentTheme = theme === 'light' ? 'light' : 'dark';
    const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
    const nextLabel = nextTheme === 'light' ? 'Modo claro' : 'Modo oscuro';

    root.setAttribute('data-theme', currentTheme);
    persistTheme(currentTheme);

    if (!button) return;

    const label = button.querySelector('[data-theme-toggle-label]');
    const icon = button.querySelector('[data-theme-toggle-icon]');

    button.setAttribute('aria-pressed', currentTheme === 'light' ? 'true' : 'false');
    button.setAttribute('aria-label', 'Cambiar a ' + nextLabel.toLowerCase());
    button.setAttribute('title', 'Cambiar a ' + nextLabel.toLowerCase());

    if (label) label.textContent = nextLabel;
    if (icon) icon.textContent = nextTheme === 'light' ? '☀️' : '🌙';
  }

  function initThemeToggle() {
    const button = document.querySelector('[data-theme-toggle]');
    if (!button) return;

    applyTheme(getStoredTheme(), button);

    button.addEventListener('click', function () {
      const currentTheme = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
      applyTheme(currentTheme === 'dark' ? 'light' : 'dark', button);
    });
  }

  function initAutoFocus() {
    const el = document.querySelector('[data-autofocus]');
    if (el && typeof el.focus === 'function') el.focus();
  }

  document.addEventListener('DOMContentLoaded', function () {
    initNavToggle();
    initThemeToggle();
    initAutoFocus();
  });
})();
