<?php
require_once 'koneksi.php';
// Query untuk mengambil jumlah yang akan hadir
$queryAkanHadir = "SELECT COUNT(*) AS jumlahAkanHadir FROM rsvp WHERE konfirmasi_kehadiran = 'Akan Hadir'";
$resultAkanHadir = $conn->query($queryAkanHadir);

// Query untuk mengambil jumlah yang masih ragu
$queryRagu = "SELECT COUNT(*) AS jumlahRagu FROM rsvp WHERE konfirmasi_kehadiran = 'Masih Ragu'";
$resultRagu = $conn->query($queryRagu);

// Inisialisasi data
$data = array();

if ($resultAkanHadir && $resultRagu) {
    $rowAkanHadir = $resultAkanHadir->fetch_assoc();
    $rowRagu = $resultRagu->fetch_assoc();

    // Isi data dengan jumlah yang akan hadir dan jumlah yang masih ragu
    $data['jumlahAkanHadir'] = $rowAkanHadir['jumlahAkanHadir'];
    $data['jumlahRagu'] = $rowRagu['jumlahRagu'];
} else {
    // Jika terdapat kesalahan dalam query
    $data['error'] = "Tidak dapat mengambil data dari tabel rsvp.";
}

// Setel header HTTP sebagai JSON
header('Content-Type: application/json');

// Kembalikan data dalam format JSON
echo json_encode($data);

// Tutup koneksi database
$conn->close();
?>
