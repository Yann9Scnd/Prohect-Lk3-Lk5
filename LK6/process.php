<?php
/**
 * File: process.php
 * Deskripsi: Menangani logika backend untuk memproses form kontak.
 */

session_start();

/**
 * Fungsi sederhana untuk membersihkan data input dari karakter berbahaya
 * @param string $data
 * @return string
 */
function bersihkanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// 1. Variabel & Array Kategori
// Menggunakan array untuk menyimpan daftar kategori pesan
$daftarKategori = ["Tanya Proyek", "Kolaborasi", "Layanan Desain", "Lainnya"];

// Cek apakah data dikirim menggunakan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Mengambil data dari form dan membersihkannya
    $nama     = bersihkanInput($_POST['nama'] ?? '');
    $email    = bersihkanInput($_POST['email'] ?? '');
    $kategori = bersihkanInput($_POST['kategori'] ?? '');
    $pesan    = bersihkanInput($_POST['pesan'] ?? '');

    $errorList = [];

    // 2. Percabangan (If-Else) untuk Validasi
    // Validasi Nama
    if (empty($nama)) {
        $errorList[] = "Nama tidak boleh kosong.";
    }

    // Validasi Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorList[] = "Format email tidak valid.";
    }

    // Validasi Pesan (Minimal 10 karakter)
    if (strlen($pesan) < 10) {
        $errorList[] = "Pesan minimal harus 10 karakter.";
    }

    // Cek apakah ada error
    if (empty($errorList)) {
        // Jika BERHASIL (tidak ada error):
        // Simpan data ke session agar bisa ditampilkan di index.php
        $_SESSION['success_data'] = [
            'nama'     => $nama,
            'email'    => $email,
            'kategori' => $kategori,
            'pesan'    => $pesan,
            'waktu'    => date("Y-m-d H:i:s")
        ];
        
        // Hapus data error/lama jika sebelumnya ada
        unset($_SESSION['errors']);
        unset($_SESSION['old_input']);
    } else {
        // Jika GAGAL (ada error):
        // Simpan pesan error dan input lama ke session
        $_SESSION['errors'] = $errorList;
        $_SESSION['old_input'] = $_POST;
        unset($_SESSION['success_data']);
    }

    // Redirect kembali ke halaman index.php pada section kontak
    header("Location: index.php#kontak");
    exit();
} else {
    // Jika mencoba akses langsung tanpa POST, tendang kembali ke index
    header("Location: index.php");
    exit();
}
?>
