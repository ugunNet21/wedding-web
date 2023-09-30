<?php
require_once('koneksi.php'); // Sesuaikan dengan nama file koneksi Anda

// Query untuk mengambil jumlah konfirmasi yang akan hadir dari tabel rsvp
$queryAkanHadir = "SELECT COUNT(*) AS jumlahAkanHadir FROM rsvp WHERE konfirmasi_kehadiran = 'Akan Hadir'";
$resultAkanHadir = $conn->query($queryAkanHadir);

// Query untuk mengambil jumlah konfirmasi yang masih ragu dari tabel rsvp
$queryRagu = "SELECT COUNT(*) AS jumlahRagu FROM rsvp WHERE konfirmasi_kehadiran = 'Masih Ragu'";
$resultRagu = $conn->query($queryRagu);

if ($resultAkanHadir && $resultRagu) {
    $rowAkanHadir = $resultAkanHadir->fetch_assoc();
    $rowRagu = $resultRagu->fetch_assoc();
} else {
    // Tidak dapat mengambil data dari tabel rsvp
    $rowAkanHadir = ['jumlahAkanHadir' => 0];
    $rowRagu = ['jumlahRagu' => 0];
}

// Tutup koneksi database jika diperlukan
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Jumlah Konfirmasi Kehadiran</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1>Jumlah Konfirmasi Kehadiran</h1>
    <p>Jumlah yang akan hadir: <span id="jumlahAkanHadir">0</span></p>
    <p>Jumlah yang masih ragu: <span id="jumlahRagu">0</span></p>
    <canvas id="konfirmasiChart" width="400" height="200"></canvas>

    <script>
        // Data jumlah konfirmasi kehadiran
        var jumlahAkanHadir = <?php echo $rowAkanHadir['jumlahAkanHadir']; ?>;
        var jumlahRagu = <?php echo $rowRagu['jumlahRagu']; ?>;

        // Update data jumlah konfirmasi kehadiran pada halaman
        document.getElementById('jumlahAkanHadir').textContent = jumlahAkanHadir;
        document.getElementById('jumlahRagu').textContent = jumlahRagu;

        // Inisialisasi grafik menggunakan Chart.js
        var ctx = document.getElementById('konfirmasiChart').getContext('2d');
        var konfirmasiChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Akan Hadir', 'Masih Ragu'],
                datasets: [{
                    label: 'Jumlah Konfirmasi Kehadiran',
                    data: [jumlahAkanHadir, jumlahRagu],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.5)', // Warna untuk Akan Hadir
                        'rgba(255, 99, 132, 0.5)' // Warna untuk Masih Ragu
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>

