<!DOCTYPE html>
<html>

<head>
    <title>RSVP Sukses</title>
    <!-- Tambahkan link ke Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tambahkan link ke font awesome untuk ikon sukses -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        // Fungsi untuk menampilkan popup pesan sukses
        function showSuccessPopup() {
            // Tampilkan pesan sukses dengan Bootstrap modal
            $('#successModal').modal('show');
        }
    </script>
</head>

<body onload="showSuccessPopup()">
    <!-- Modal Pesan Sukses -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">RSVP Sukses!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Terima kasih atas konfirmasi kehadiran Anda.</p>
                </div>
                <div class="modal-footer">
                    <!-- Tambahkan tombol untuk kembali ke halaman utama -->
                    <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan script jQuery dan Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>