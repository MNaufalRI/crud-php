<?php
session_start();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KomikVerse — Jelajahi Dunia Komik</title>
  <meta name="description" content="Landing page Web Baca Komik - baca webtoon, manhwa, manga, dan komik lokal.">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <div class="container">
      <div class="header-left">
        <button id="menu-toggle" class="menu-btn">☰</button>
        <h1 class="logo">KomikVerse</h1>
      </div>
      <nav>
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#popular">Popular</a></li>
          <li><a href="#kategori">Kategori</a></li>
          <li><a href="#about">About</a></li>
        </ul>
      </nav>
    </div>
  </header>
  
  <div id="sidebar" class="sidebar">
    <div class="sidebar-content">
      <?php if (isset($_SESSION['username'])): ?>
        <a href="dashboard.php" class="sidebar-link">Dashboard</a>
        <a href="logout.php" class="sidebar-link">Logout</a>
      <?php else: ?>
        <a href="login.php" class="sidebar-link">Login</a>
      <?php endif; ?>
      
      <a href="#" class="sidebar-link">Bookmark</a>
      <button id="theme-toggle" class="theme-btn-text">Light Mode</button>
    </div>
  </div>
  <div id="overlay" class="overlay"></div>


  <main>
    <section id="home" class="hero">
        <div class="container">
            <h2>Baca Komik Favoritmu — Cepat &amp; Nyaman</h2>
            <p>Jelajahi ribuan manga, manhwa, dan manhua dari berbagai genre. Temukan episode terbaru, bookmark cerita, dan baca di mana saja.</p>
            <div class="hero-image-slider">
                <img src="images/drstone.jpg" alt="Dr.Stone">
                <img src="images/sakamoto.jpg" alt="Sakamoto Days">
                <img src="images/slragnarok.webp" alt="Solo Leveling Ragnarok">
                <img src="images/tgoh.jpg" alt="The God of High School">
            </div>
            <div class="hero-buttons">
                <a href="#popular" class="btn btn-primary">Jelajahi Sekarang</a>
                <a href="#about" class="btn btn-secondary">Pelajari lebih lanjut</a>
            </div>
        </div>
    </section>
    <section id="features">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="card"><h3>Bookmark & Lanjutkan</h3><p>Simpan posisi baca dan lanjutkan kapan saja dengan mudah.</p></div>
                <div class="card"><h3>Genre Beragam</h3><p>Dari romantis, aksi, fantasi, hingga slice-of-life.</p></div>
                <div class="card"><h3>Notifikasi Episode Baru</h3><p>Dapatkan pemberitahuan instan saat episode baru terbit.</p></div>
                <div class="card"><h3>Mode Malam</h3><p>Baca nyaman di malam hari tanpa menyilaukan mata.</p></div>
            </div>
        </div>
    </section>
    <section id="popular">
        <div class="container">
            <h2 class="section-title">Komik Populer</h2>
            <div class="comics-grid"></div>
        </div>
    </section>

    <section id="kategori">
        <div class="container">
            <h2 class="section-title">Telusuri Berdasarkan Genre</h2>
            <ul class="genre-list">
                <li><a href="#" class="genre-tag">Romantis</a></li>
                <li><a href="#" class="genre-tag">Aksi</a></li>
                <li><a href="#" class="genre-tag">Fantasi</a></li>
                <li><a href="#" class="genre-tag">Slice of Life</a></li>
                <li><a href="#" class="genre-tag">Komedi</a></li>
                <li><a href="#" class="genre-tag">Sci-Fi</a></li>
                <li><a href="#" class="genre-tag">Horor</a></li>
            </ul>
            <div class="comics-grid" style="margin-top: 40px;">
              </div>
        </div>
    </section>

    <aside id="about">
        <div class="container">
            <h2>Tentang KomikVerse</h2>
            <p>KomikVerse adalah sebuah prototipe landing page yang dibuat untuk menampilkan koleksi komik digital dengan antarmuka yang bersih dan modern, terinspirasi dari platform baca komik populer.</p>
        </div>
    </aside>
  </main>

  <footer>
    <div class="container">
      <p>&copy; 2025 KomikVerse. Dibuat dengan inspirasi dari <a href="https://www.webtoons.com" target="_blank" rel="noopener">Webtoon</a></p>
    </div>
  </footer>

  <script src="script.js" defer></script>
</body>
</html>