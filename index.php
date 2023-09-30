<?php
require_once 'koneksi.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Undangan Pernikahan</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <header>
    <h1>Undangan Pernikahan</h1>
    <nav>
      <ul>
        <li><a href="#beranda">Beranda</a></li>
        <li><a href="#acara">Acara</a></li>
        <li><a href="#galeri">Galeri</a></li>
        <li><a href="#rsvp">RSVP</a></li>
      </ul>
    </nav>
  </header>
  <section id="acara">
    <?php
    setlocale(LC_TIME, 'id_ID'); // Setel locale ke bahasa Indonesia

    $query = "SELECT * FROM undangan";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<div class="container">';
        echo "<h2>Acara Pernikahan</h2>";
        echo "<p>" . $row["nama_pengantin_pria"] . " & " . $row["nama_pengantin_wanita"] . "</p>";

        echo "<h3>Akad Nikah</h3>";

        echo '<div class="container">';
        echo '<h2><i class="far fa-calendar"></i> Tanggal</h2>';
        echo '<p>Acara pernikahan akan dilaksanakan pada:</p>';
        echo '<p>' . strftime('%A, %d %B %Y', strtotime($row["tanggal_pernikahan"])) . '</p>'; // Format tanggal ke bahasa Indonesia
        echo '</div>';

        echo '<div class="container">';
        echo '<h2><i class="far fa-clock"></i> Waktu</h2>';
        echo '<p>Acara pernikahan akan dimulai pada:</p>';
        echo '<p>' . $row["waktu_pernikahan"] . '</p>';
        echo '</div>';

        echo '<div class="container">';
        echo '<h2><i class="fas fa-map-marker"></i> Lokasi</h2>';
        echo '<p>Acara Akad pernikahan akan diselenggarakan di tempat berikut:</p>';
        echo '<address>Alamat: ' . $row["lokasi_pernikahan"] . '</address>';
        echo '</div>';
      }
    } else {
      echo "Tidak ada data undangan yang ditemukan.";
    }

    // Kueri SQL untuk mengambil data resepsi
    $query = "SELECT * FROM resepsi";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      // Loop melalui hasil query dan tampilkan data resepsi
      while ($row = $result->fetch_assoc()) {
        echo "<h3>Resepsi Pernikahan</h3>";
        echo "<div class='container'>";
        echo "<h2><i class='far fa-calendar'></i> Tanggal</h2>";
        echo "<p>Acara Resepsi pernikahan akan dilaksanakan pada:</p>";
        echo '<p>' . strftime('%A, %d %B %Y', strtotime($row["tanggal"])) . '</p>'; // Format tanggal ke bahasa Indonesia
        echo "</div>";

        echo "<div class='container'>";
        echo "<h2><i class='far fa-clock'></i> Waktu</h2>";
        echo "<p>Acara pernikahan akan dimulai pada:</p>";
        echo "<p>" . $row["waktu"] . '</p>';
        echo "</div>";

        echo "<div class='container'>";
        echo "<h2><i class='fas fa-map-marker'></i> Lokasi</h2>";
        echo "<p>Acara pernikahan akan diselenggarakan di tempat berikut:</p>";
        echo '<address>Alamat: ' . $row["lokasi"] . '</address>';
        echo "</div>";
      }
    } else {
      echo "Tidak ada data resepsi yang ditemukan.";
    }

    ?>
  </section>
  <section>
    <div class="container">
      <audio id="myAudio" autoplay loop>
        <source src="./assets/mp3/natural-songs-wedding.mp3" type="audio/mpeg">
        Browser Anda tidak mendukung tag audio.
      </audio>
      <button onclick="toggleAudio()">Play/Stop Audio</button>
      <!-- <button onclick="adjustVolume(0.5)">Atur Volume (50%)</button> -->
    </div>
  </section>
  <section>
    <div class="container mt-5 text-center">
      <h1> Menuju Pernikahan</h1>
      <div class="alert alert-info" role="alert">
        <i class="fas fa-bell"></i> Pernikahan akan berlangsung dalam:
        <div id="countdown" class="font-weight-bold"></div>
      </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="./js/countdown.js"></script>
  </section>
  <section id="galeri">
    <h2>Galeri</h2>
    <p>
      Kami ingin berbagi beberapa momen istimewa dari persiapan pernikahan
      kami. Semoga Anda menikmati foto-foto berikut:
    </p>

    <?php
    // Query untuk mengambil data galeri dari tabel
    $query = "SELECT * FROM galeri";
    $result = $conn->query($query);

    // Loop melalui hasil query dan tampilkan foto-foto
    while ($row = $result->fetch_assoc()) {
    ?>
      <div class="foto">
        <img src="<?php echo $row['gambar_galeri']; ?>" alt="<?php echo $row['judul_foto']; ?>" />
        <p><?php echo $row['deskripsi_foto']; ?></p>
      </div>
    <?php
    }
    ?>

    <?php

    ?>

    <!-- Tambahkan lebih banyak foto dan deskripsi sesuai kebutuhan -->
  </section>

  <?php
  // Fungsi untuk membersihkan dan melindungi data yang dikirim dari formulir
  function sanitizeInput($input)
  {
    return htmlspecialchars(stripslashes(trim($input)));
  }

  // Cek apakah permintaan adalah POST
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir dan bersihkan
    $nama = sanitizeInput($_POST["nama"]);
    $email = sanitizeInput($_POST["email"]);
    $nomorWA = sanitizeInput($_POST["nomor-wa"]);
    $konfirmasi = sanitizeInput($_POST["konfirmasi"]);
    $hadiah = isset($_POST["hadiah"]) ? sanitizeInput($_POST["hadiah"]) : null;
    $nomorRekening = isset($_POST["nomor-rek"]) ? sanitizeInput($_POST["nomor-rek"]) : null;
    $pesanUcapan = sanitizeInput($_POST["pesan-ucapan"]);

    // Masukkan data ke dalam tabel RSVP
    $sql = "INSERT INTO rsvp (nama_tamu, email_tamu, nomor_whatsapp, konfirmasi_kehadiran, pilihan_hadiah, nomor_rekening, pesan_ucapan) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nama, $email, $nomorWA, $konfirmasi, $hadiah, $nomorRekening, $pesanUcapan);

    if ($stmt->execute()) {
      // Jika berhasil, arahkan kembali ke halaman RSVP
      header("Location: index.php#rsvp");
      exit();
    } else {
      // Jika gagal, tampilkan pesan kesalahan
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi database
    $stmt->close();
  }
  ?>
  <section id="rsvp">
    <h2>RSVP</h2>
    <p>
      Kami akan sangat senang jika Anda bisa hadir dalam hari bahagia kami.
      Mohon konfirmasikan kehadiran Anda:
    </p>

    <form id="rsvpForm" method="POST" action="proses_rsvp.php">
      <label for="nama">Nama Lengkap:</label>
      <input type="text" id="nama" name="nama" required />

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required />

      <label for="nomor-wa">Nomor WhatsApp:</label>
      <input type="text" id="nomor-wa" name="nomor-wa" required>

      <label for="konfirmasi">Konfirmasi Kehadiran:</label>
      <select id="konfirmasi" name="konfirmasi" onchange="tampilkanNomorRekening()">
        <option value="Akan Hadir">Akan Hadir</option>
        <option value="Akan Hadir Ngasih Hadiah">
          Akan Hadir (Ngasih Hadiah)
        </option>
        <option value="Maff Tidak Bisa Hadir">
          Maaf Tidak Bisa Hadir (Ngasih hadiah)
        </option>
        <option value="Masih Ragu">Masih Ragu</option>
      </select>

      <div id="hadiah-option" style="display: none">
        <label>Pilihan Hadiah:</label>
        <input type="radio" id="kirim-rekening" name="hadiah" value="Kirim Rekening" />
        <label for="kirim-rekening">Kirim Rekening</label>

        <input type="radio" id="kirim-kado" name="hadiah" value="Kirim Kado Bentuk Barang" />
        <label for="kirim-kado">Kirim Kado Bentuk Barang</label>
      </div>

      <div id="nomor-rekening" style="display: none">
        <label for="nomor-rek">Nomor Rekening:</label>
        <input type="text" id="nomor-rek" name="nomor-rek" />
      </div>

      <div id="pesan">
        <label for="pesan-ucapan">Pesan Ucapan:</label>
        <textarea id="pesan-ucapan" name="pesan-ucapan"></textarea>
      </div>

      <button type="submit" onclick="submitRSVP()">Kirim Konfirmasi</button>
    </form>
  </section>
  
  <div class="container mt-5">
    <section id="jumlah-konfirmasi" style="margin-bottom: 20px;">

      <h2 class="mb-3">Jumlah Konfirmasi Kehadiran</h2>
      <p>Jumlah total konfirmasi kehadiran:</p>
      <p>Jumlah yang akan hadir: <span id="jumlahAkanHadir">0</span></p>
      <p>Jumlah yang masih ragu: <span id="jumlahRagu">0</span></p>
      <canvas id="konfirmasiChart" width="400" height="200">
        <?php
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
      </canvas>
    </section>

  </div>

  <footer>
    <p>Terima kasih telah datang!</p>
  </footer>

  <script src="/js/script.js"></script>
</body>

</html>

<script>
  function tampilkanNomorRekening() {
    var konfirmasi = document.getElementById("konfirmasi").value;
    var hadiahOption = document.getElementById("hadiah-option");
    var nomorRekening = document.getElementById("nomor-rekening");

    if (
      konfirmasi === "Akan Hadir Ngasih Hadiah" ||
      konfirmasi === "Maff Tidak Bisa Hadir"
    ) {
      hadiahOption.style.display = "block";

      // Periksa apakah pilihan hadiah adalah "Kirim Kado Bentuk Barang"
      var hadiah = document.querySelector('input[name="hadiah"]:checked');
      if (hadiah && hadiah.value === "Kirim Kado Bentuk Barang") {
        nomorRekening.style.display = "none";
      } else {
        nomorRekening.style.display = "block";
      }
    } else {
      hadiahOption.style.display = "none";
      nomorRekening.style.display = "none";
    }
  }

  function submitRSVP() {
    document.getElementById("rsvpForm").action = "proses_rsvp.php";
    // Ambil data dari formulir dan lakukan apa yang diperlukan.
    // Contoh: Validasi, kirim data ke server, dll.
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- grafik kehadiran -->

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

<!-- script audio -->
<script>
  var audio = document.getElementById("myAudio");

  function toggleAudio() {
    if (audio.paused) {
      audio.play();
    } else {
      audio.pause();
    }
  }

  function adjustVolume(volume) {
    audio.volume = volume;
  }
</script>