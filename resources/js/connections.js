  const filtersBtn = document.getElementById('filtersBtn');
  const filtersDropdown = document.getElementById('filtersDropdown');

  filtersBtn.addEventListener('click', () => {
    filtersDropdown.style.display = filtersDropdown.style.display === 'flex' ? 'none' : 'flex';
  });

  document.addEventListener('click', (e) => {
    if (!filtersBtn.contains(e.target) && !filtersDropdown.contains(e.target)) {
      filtersDropdown.style.display = 'none';
    }
  });

  document.querySelectorAll('.filters-dropdown button').forEach(btn => {
  btn.addEventListener('click', () => {
    const pressed = btn.getAttribute('aria-pressed') === 'true';
    btn.setAttribute('aria-pressed', !pressed);
  });
});