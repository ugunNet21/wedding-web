
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_undangan";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}
