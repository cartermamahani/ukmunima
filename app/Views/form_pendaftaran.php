<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>
<!-- <head>
    <title>Pendaftaran Calon Pengurus UKM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head> -->

<div class="card bg-white border-primary contentCard">
    <div class="card-body">
        <div class="container mt-5">

            <!-- File: app/Views/form_pendaftaran.php -->


            <div class="container mt-5">
                <h2>Formulir Pendaftaran Pengurus UKM</h2>

                <!-- Tambahkan form Bootstrap -->
                <form action="<?php echo base_url('pendaftaran/submit'); ?>" method="post">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" required>
                    </div>

                    <div class="form-group">
                        <label for="terlibat_pelayanan">Terlibat Pelayanan</label>
                        <input type="number" class="form-control" id="terlibat_pelayanan" name="terlibat_pelayanan" required>
                    </div>

                    <div class="form-group">
                        <label for="memahami_pdp">Memahami PDP</label>
                        <input type="number" class="form-control" id="memahami_pdp" name="memahami_pdp" required>
                    </div>

                    <div class="form-group">
                        <label for="student_bible_meeting">Student Bible Meeting</label>
                        <input type="number" class="form-control" id="student_bible_meeting" name="student_bible_meeting" required>
                    </div>

                    <div class="form-group">
                        <label for="tidak_menjabat">Tidak Menjabat</label>
                        <input type="number" class="form-control" id="tidak_menjabat" name="tidak_menjabat" required>
                    </div>

                    <div class="form-group">
                        <label for="dimuridkan">Dimuridkan</label>
                        <input type="number" class="form-control" id="dimuridkan" name="dimuridkan" required>
                    </div>

                    <div class="form-group">
                        <label for="aktiv_kuliah">Aktiv Kuliah</label>
                        <input type="number" class="form-control" id="aktiv_kuliah" name="aktiv_kuliah" required>
                    </div>


                    <!-- Tambahkan input untuk kriteria lainnya sesuai kebutuhan -->

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <!-- Tambahkan script JS Bootstrap -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>





        </div>
    </div>
</div>

<?php include('template/footer.php'); ?>

</html>