// Tanggal dan waktu pernikahan yang ditetapkan (sesuaikan dengan format YYYY-MM-DD HH:MM:SS)
var weddingDate = new Date("2023-12-31 18:00:00").getTime();

// Update countdown setiap detik
var countdown = setInterval(function () {
  // Waktu saat ini
  var now = new Date().getTime();

  // Selisih waktu antara saat ini dan tanggal pernikahan
  var timeRemaining = weddingDate - now;

  // Hitung hari, jam, menit, dan detik
  var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
  var hours = Math.floor(
    (timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

  // Tampilkan hasil countdown pada elemen HTML
  var countdownElement = document.getElementById("countdown");
  countdownElement.innerHTML =
    days +
    " hari " +
    hours +
    " jam " +
    minutes +
    " menit " +
    seconds +
    " detik ";

  // Jika waktu pernikahan sudah lewat, hentikan countdown
  if (timeRemaining < 0) {
    clearInterval(countdown);
    countdownElement.innerHTML = "Pernikahan telah berlangsung!";
  }
}, 1000); // Setiap 1 detik
