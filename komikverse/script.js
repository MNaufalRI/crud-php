document.addEventListener('DOMContentLoaded', () => {

  // --- 1. DEFINISI VARIABEL UTAMA ---
  const menuToggle = document.getElementById('menu-toggle');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const navLinks = document.querySelectorAll('header nav a');
  const popularGrid = document.querySelector('#popular .comics-grid');
  const kategoriGrid = document.querySelector('#kategori .comics-grid');
  const genreTags = document.querySelectorAll('.genre-tag');
  const sections = document.querySelectorAll('section[id], aside[id]');
  const themeToggle = document.getElementById('theme-toggle');
  const body = document.body;

  // --- 2. FUNGSI SIDEBAR & OVERLAY ---
  function toggleSidebar() {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('show');
  }
  menuToggle.addEventListener('click', toggleSidebar);
  overlay.addEventListener('click', toggleSidebar);

  // --- 3. FUNGSI SMOOTH SCROLLING ---
  navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = this.getAttribute('href');
      const targetSection = document.querySelector(targetId);
      if (targetSection) {
        targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // --- 4. FUNGSI KONTEN DINAMIS (FETCH API) ---
  const genreMap = {
    'romantis': 22, 'aksi': 1, 'fantasi': 10, 'slice of life': 36,
    'komedi': 4, 'sci-fi': 24, 'horor': 14
  };
  
  function displayComics(comics, container) {
    container.innerHTML = ''; 
    comics.forEach(comic => {
      const authors = comic.authors.map(author => author.name).join(', ');
      const chapterInfo = comic.chapters ? `Ch. ${comic.chapters}` : 'Publishing';
      const comicCardHTML = `
        <article class="card comic-card">
          <img src="${comic.images.webp.large_image_url}" alt="${comic.title}">
          <div class="comic-info">
            <h3>${comic.title}</h3>
            <p>${authors} • ${chapterInfo}</p>
          </div>
        </article>`;
      container.insertAdjacentHTML('beforeend', comicCardHTML);
    });
  }
  
  async function fetchComics(url, container) {
    container.innerHTML = '<p style="text-align:center; width:100%;">Memuat komik...</p>';
    try {
      const response = await fetch(url);
      if (!response.ok) throw new Error(`Gagal mengambil data!`);
      const data = await response.json();
      displayComics(data.data, container);
    } catch (error) {
      console.error("Tidak dapat mengambil data komik:", error);
      container.innerHTML = '<p style="text-align:center; width:100%;">Maaf, gagal memuat komik.</p>';
    }
  }

  fetchComics('https://api.jikan.moe/v4/top/manga?limit=4&filter=publishing', popularGrid);
  
  genreTags.forEach(tag => {
    tag.addEventListener('click', (e) => {
      e.preventDefault();
      genreTags.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      const genreName = e.currentTarget.textContent.toLowerCase();
      const genreId = genreMap[genreName];
      if (genreId) {
        const url = `https://api.jikan.moe/v4/manga?genres=${genreId}&limit=4&order_by=popularity`;
        fetchComics(url, kategoriGrid);
      }
    });
  });

  function loadInitialGenre() {
    const initialGenreTag = document.querySelector('.genre-tag');
    if (initialGenreTag) {
      initialGenreTag.classList.add('active');
      const initialGenreName = initialGenreTag.textContent.toLowerCase();
      const initialGenreId = genreMap[initialGenreName];
      if (initialGenreId) {
        const initialUrl = `https://api.jikan.moe/v4/manga?genres=${initialGenreId}&limit=4&order_by=popularity`;
        fetchComics(initialUrl, kategoriGrid);
      }
    }
  }
  loadInitialGenre();

  // --- 5. FUNGSI LIGHT/DARK MODE ---
  function updateThemeButtonText() {
    if (body.classList.contains('light-mode')) {
      themeToggle.textContent = 'Dark Mode';
    } else {
      themeToggle.textContent = 'Light Mode';
    }
  }

  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'light') {
    body.classList.add('light-mode');
  }
  updateThemeButtonText();

  themeToggle.addEventListener('click', () => {
    body.classList.toggle('light-mode');
    if (body.classList.contains('light-mode')) {
      localStorage.setItem('theme', 'light');
    } else {
      localStorage.setItem('theme', 'dark');
    }
    updateThemeButtonText();
  });

  // --- 6. NAVIGASI AKTIF SAAT SCROLL (HANYA SATU EVENT LISTENER) ---
  window.addEventListener('scroll', () => {
    let currentSectionId = '';
    sections.forEach(section => {
      const sectionTop = section.offsetTop;
      if (window.pageYOffset >= sectionTop - 150) {
        currentSectionId = section.getAttribute('id');
      }
    });
    navLinks.forEach(link => {
      link.classList.remove('active');
      const href = link.getAttribute('href');
      if (href === `#${currentSectionId}`) {
        link.classList.add('active');
      }
    });
  });

});

// --- 7. KONFIRMASI DELETE UNTUK CRUD ---
  const deleteButtons = document.querySelectorAll('.btn-hapus');
  deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      // Ambil judul komik dari data-attribute
      const judul = e.currentTarget.getAttribute('data-judul');
      
      // Tampilkan dialog konfirmasi
      const message = `Apakah Anda yakin ingin menghapus komik "${judul}"?\n\nAksi ini tidak dapat dibatalkan.`;
      
      if (!confirm(message)) {
        // Jika pengguna klik "Batal", hentikan navigasi
        e.preventDefault();
      }
    });
  });