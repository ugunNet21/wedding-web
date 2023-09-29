// Ambil elemen-elemen yang akan diberi animasi
const acaraElemen = document.getElementById("acara");
const galeriElemen = document.getElementById("galeri");
const rsvpElemen = document.getElementById("rsvp");

// Tambahkan event listener untuk setiap elemen
acaraElemen.addEventListener("click", () => {
  // Tambahkan atau hapus kelas "animate" untuk mengaktifkan atau menonaktifkan animasi
  acaraElemen.classList.toggle("animate");
});

galeriElemen.addEventListener("click", () => {
  galeriElemen.classList.toggle("animate");
});

rsvpElemen.addEventListener("click", () => {
  rsvpElemen.classList.toggle("animate");
});
