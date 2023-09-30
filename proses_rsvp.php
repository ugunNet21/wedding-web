<?php
require_once 'koneksi.php';

function sanitizeInput($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = isset($_POST["nama"]) ? sanitizeInput($_POST["nama"]) : null;
    $email = isset($_POST["email"]) ? sanitizeInput($_POST["email"]) : null;
    $nomorWA = isset($_POST["nomor-wa"]) ? sanitizeInput($_POST["nomor-wa"]) : null;
    $konfirmasi = isset($_POST["konfirmasi"]) ? sanitizeInput($_POST["konfirmasi"]) : null;
    $hadiah = isset($_POST["hadiah"]) ? sanitizeInput($_POST["hadiah"]) : null;
    $nomorRekening = isset($_POST["nomor-rek"]) ? sanitizeInput($_POST["nomor-rek"]) : null;
    $pesanUcapan = isset($_POST["pesan-ucapan"]) ? sanitizeInput($_POST["pesan-ucapan"]) : null;

    // Validasi data di sisi server
    if ($nama && $email && $nomorWA && $konfirmasi) {
        // Periksa duplikasi data
        $sql = "SELECT COUNT(*) FROM rsvp WHERE email_tamu = ? OR nomor_whatsapp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $nomorWA);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            // Data duplikat ditemukan, tampilkan pesan kesalahan
            echo "<div class='container mt-5 d-flex justify-content-center align-items-center' style='height: 20vh;'>
                <div class='card p-4 text-center' style='border-radius: 15px;'>
                    <h4 class='card-title mb-4'>RSVP Gagal!</h4>
                    <p class='card-text' style='color: red;'>Maaf, email atau nomor WhatsApp ini sudah terdaftar.</p>
                    <a class='btn btn-primary' href='index.php#rsvp'>Kembali ke Form RSVP</a>
                </div>
                </div>";
        } else {
            // Lanjutkan dengan penyisipan ke database
            $sql = "INSERT INTO rsvp (nama_tamu, email_tamu, nomor_whatsapp, konfirmasi_kehadiran, pilihan_hadiah, nomor_rekening, pesan_ucapan) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $nama, $email, $nomorWA, $konfirmasi, $hadiah, $nomorRekening, $pesanUcapan);

            if ($stmt->execute()) {
                // Jika berhasil, arahkan kembali ke halaman RSVP sukses
                header("Location: sukses.php");
                exit();
            } else {
                // Jika gagal, tampilkan pesan kesalahan
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        // Data tidak lengkap, tampilkan pesan kesalahan kepada pengguna
        echo "Silakan isi semua kolom yang diperlukan.";
    }
} else {
    // Jika bukan permintaan POST, arahkan ke halaman lain atau tampilkan pesan sesuai kebutuhan.
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>RSVP Gagal</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <!-- <div class="container">
        <h4>RSVP Gagal!</h4>
        <p>Maaf, email atau nomor WhatsApp ini sudah terdaftar.</p>
        <a href="index.php#rsvp">Kembali ke Form RSVP</a>
    </div> -->
</body>

</html>
