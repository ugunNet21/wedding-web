<?php
require_once('koneksi.php');

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
    $query = "SELECT * FROM undangan";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<h2>Acara Pernikahan</h2>";
        echo "<p>" . $row["nama_pengantin_pria"] . " & " . $row["nama_pengantin_wanita"] . "</p>";

        echo "<h3>Akad Nikah</h3>";

        echo '<div class="container">';
        echo '<h2><i class="far fa-calendar"></i> Tanggal</h2>';
        echo '<p>Acara pernikahan akan dilaksanakan pada:</p>';
        echo '<p>' . $row["tanggal_pernikahan"] . '</p>';
        echo '</div>';

        echo '<div class="container">';
        echo '<h2><i class="far fa-clock"></i> Waktu</h2>';
        echo '<p>Acara pernikahan akan dimulai pada:</p>';
        echo '<p>' . $row["waktu_pernikahan"] . '</p>';
        echo '</div>';

        echo '<div class="container">';
        echo '<h2><i class="fas fa-map-marker"></i> Lokasi</h2>';
        echo '<p>Acara pernikahan akan diselenggarakan di tempat berikut:</p>';
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
        echo "<p>Acara pernikahan akan dilaksanakan pada:</p>";
        echo "<p>" . $row["tanggal"] . "</p>";
        echo "</div>";

        echo "<div class='container'>";
        echo "<h2><i class='far fa-clock'></i> Waktu</h2>";
        echo "<p>Acara pernikahan akan dimulai pada:</p>";
        echo "<p>" . $row["waktu"] . "</p>";
        echo "</div>";

        echo "<div class='container'>";
        echo "<h2><i class='fas fa-map-marker'></i> Lokasi</h2>";
        echo "<p>Acara pernikahan akan diselenggarakan di tempat berikut:</p>";
        echo "<address>Alamat: " . $row["lokasi"] . "</address>";
        echo "</div>";
      }
    } else {
      echo "Tidak ada data resepsi yang ditemukan.";
    }

    ?>
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
    // Tutup koneksi
    $conn->close();
    ?>

    <!-- Tambahkan lebih banyak foto dan deskripsi sesuai kebutuhan -->
  </section>

  <section id="rsvp">
    <h2>RSVP</h2>
    <p>
      Kami akan sangat senang jika Anda bisa hadir dalam hari bahagia kami.
      Mohon konfirmasikan kehadiran Anda:
    </p>

    <form id="rsvpForm">
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
    // Ambil data dari formulir dan lakukan apa yang diperlukan.
    // Contoh: Validasi, kirim data ke server, dll.
  }
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



<!-- <script>
    function submitRSVP() {
        var nama = document.getElementById("nama").value;
        var email = document.getElementById("email").value;
        var nomorWA = document.getElementById("nomor-wa").value;
        var konfirmasi = document.getElementById("konfirmasi").value;
        var hadiahOption = document.querySelector('input[name="hadiah"]:checked').value;
        var nomorRekening = document.getElementById("nomor-rek").value;
        var pesanUcapan = document.getElementById("pesan-ucapan").value;

        // Lakukan apa pun yang diperlukan dengan data yang diambil dari formulir.
        // Misalnya, Anda dapat mengirim data ini ke server atau melakukan validasi.

        // Contoh: Tampilkan data di konsol.
        console.log("Nama: " + nama);
        console.log("Email: " + email);
        console.log("Nomor WhatsApp: " + nomorWA);
        console.log("Konfirmasi Kehadiran: " + konfirmasi);
        console.log("Pilihan Hadiah: " + hadiahOption);
        console.log("Nomor Rekening: " + nomorRekening);
        console.log("Pesan Ucapan: " + pesanUcapan);
    }

    // Sembunyikan atau tampilkan bagian pilihan hadiah dan nomor rekening berdasarkan pilihan pengguna.
    var hadiahOption = document.getElementById("hadiah-option");
    var nomorRekening = document.getElementById("nomor-rekening");

    hadiahOption.style.display = "none"; // Sembunyikan awalnya

    document.querySelector('input[name="hadiah"]').forEach(function (radio) {
        radio.addEventListener("change", function () {
            if (this.value === "Kirim Rekening") {
                nomorRekening.style.display = "block";
            } else {
                nomorRekening.style.display = "none";
            }
        });
    });
</script> -->