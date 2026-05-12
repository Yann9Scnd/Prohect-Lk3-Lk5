<?php
/**
 * File: index.php
 * Deskripsi: Halaman utama portofolio yang terintegrasi dengan backend PHP.
 */

session_start();

// Array Kategori Pesan (Akan di-loop menggunakan foreach di dalam form)
$categories = ["Tanya Proyek", "Kolaborasi", "Layanan Desain", "Lainnya"];

// Mengambil data dari session jika ada
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old_input'] ?? [];
$success = $_SESSION['success_data'] ?? null;

// Hapus session setelah diambil agar tidak muncul terus saat refresh
unset($_SESSION['errors']);
unset($_SESSION['old_input']);
unset($_SESSION['success_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Muhammad Mardiansyah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <canvas class="particles" id="particles"></canvas>

<header class="navbar">
  <div class="nav-container">
    <div class="logo">Mardiansyah</div>
    <ul class="nav-menu">
      <li><a href="#tentang">Tentang</a></li>
      <li><a href="#skill">Skill</a></li>
      <li><a href="#proyek">Proyek</a></li>
      <li><a href="#kontak">Kontak</a></li>
    </ul>
  </div>
</header>

<section class="hero">
  <div class="avatar-wrap">
    <img
      src="fotosaya.png"
      alt="Muhammad Mardiansyah"
      onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22><rect width=%22150%22 height=%22150%22 fill=%22%231e293b%22/><text x=%2275%22 y=%2290%22 text-anchor=%22middle%22 fill=%22%2338bdf8%22 font-size=%2248%22 font-family=%22sans-serif%22>MM</text></svg>'"
    />
    <div class="avatar-ring"></div>
  </div>

  <h1>
    Muhammad <span>Mardiansyah</span>
  </h1>

  <div class="typewriter">
    <span id="typed"></span>
    <span class="cursor"></span>
  </div>

  <div class="hero-btns">
    <button
      class="btn-primary"
      onclick="document.getElementById('proyek').scrollIntoView({behavior:'smooth'})"
    >
      Lihat Proyek
    </button>
    <button
      class="btn-outline"
      onclick="document.getElementById('kontak').scrollIntoView({behavior:'smooth'})"
    >
      Hubungi Saya
    </button>
  </div>
</section>

<main>
  <!-- ================= TENTANG ================= -->
  <section id="tentang">
    <div class="section-header">
      <h2>Tentang Saya</h2>
      <div class="section-line"></div>
    </div>
    <div class="about-card">
      <p>
        Saya adalah mahasiswa dengan fokus pada
        <strong style="color:#38bdf8">UI/UX Design</strong>
        dan
        <strong style="color:#38bdf8">Fullstack Development</strong>.
        Saya juga aktif sebagai influencer di bidang IT, berbagi wawasan teknologi.
      </p>
      <div class="stats">
        <div class="stat">
          <div class="stat-num" data-count="10">0</div>
          <div class="stat-label">Proyek Selesai</div>
        </div>
        <div class="stat">
          <div class="stat-num" data-count="3">0</div>
          <div class="stat-label">Tahun Belajar</div>
        </div>
        <div class="stat">
          <div class="stat-num" data-count="5">0</div>
          <div class="stat-label">Teknologi</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= KONTAK & GUESTBOOK ================= -->
  <section id="kontak">
    <div class="section-header">
      <h2>Kontak & Buku Tamu</h2>
      <div class="section-line"></div>
    </div>

    <div class="contact-grid">
      <div class="contact-info">
        <div class="contact-item">
          <div class="contact-icon">📧</div>
          <div class="contact-text">
            <p>Email</p>
            <span>mardiansyahiayan2005@email.com</span>
          </div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">📸</div>
          <div class="contact-text">
            <p>Instagram</p>
            <span>@_d.iyan</span>
          </div>
        </div>
        
        <?php if ($success): ?>
        <!-- Menampilkan Hasil Input Jika Berhasil -->
        <div class="result-card">
            <h3>Pesan Terkirim! ✅</h3>
            <div class="result-item"><strong>Nama:</strong> <?php echo $success['nama']; ?></div>
            <div class="result-item"><strong>Email:</strong> <?php echo $success['email']; ?></div>
            <div class="result-item"><strong>Kategori:</strong> <?php echo $success['kategori']; ?></div>
            <div class="result-item"><strong>Pesan:</strong> <?php echo $success['pesan']; ?></div>
            <p class="result-time">Dikirim pada: <?php echo $success['waktu']; ?></p>
        </div>
        <?php endif; ?>
      </div>

      <div class="form-card">
        <!-- Menampilkan Error Jika Ada -->
        <?php if (!empty($errors)): ?>
          <div class="error-box">
            <ul>
              <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form action="process.php" method="POST">
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" name="nama" id="nama" placeholder="Nama kamu" value="<?php echo $old['nama'] ?? ''; ?>">
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" placeholder="email@contoh.com" value="<?php echo $old['email'] ?? ''; ?>">
            </div>

            <div class="form-group">
              <label for="kategori">Kategori Pesan</label>
              <select name="kategori" id="kategori">
                  <?php 
                  // Perulangan Foreach untuk menampilkan kategori dari array
                  foreach ($categories as $cat): 
                    $selected = (isset($old['kategori']) && $old['kategori'] == $cat) ? 'selected' : '';
                  ?>
                    <option value="<?php echo $cat; ?>" <?php echo $selected; ?>><?php echo $cat; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="pesan">Pesan</label>
              <textarea name="pesan" id="pesan" rows="4" placeholder="Tulis pesan kamu..."><?php echo $old['pesan'] ?? ''; ?></textarea>
            </div>

            <button type="submit" class="send-btn">
              Kirim Pesan ✉️
            </button>
        </form>
      </div>
    </div>
  </section>
</main>

<footer>
  <p>© 2026 Muhammad Mardiansyah — Dibuat dengan 💙</p>
</footer>

<button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">↑</button>

<script src="script.js"></script>
</body>
</html>
