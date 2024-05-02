<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="addSuccessToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Tambah Data Berhasil!
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="deleteFailToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Gagal</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Gagal Menghapus Data! Mohon Segarkan Halaman
        </div>
    </div>
</div>

<div class="card bg-white border-primary contentCard">
    <div class="card-body">
        <div class="fontbold">
            <h3 class="card-title text-center" style="font-size: 20pt;">Formulir Pendaftaran <br> BIRO PELAYANAN MAHASISWA KRISTEN (BPMK)</h3>
        </div>
        <div class="d-flex justify-content-center align-items-center w-100">
            <form class="w-50 " id="daftar" action="<?= base_url('daftar_bpmk') ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <div class="mb-3">
                    <label class="form-check-label">Terlibat aktif dalam pelayanan UPK-MK dan BPMK?</label>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="aktiv_pelayanan" name="aktiv_pelayanan">
                        <label class="form-check-label" for="aktiv_pelayanan">Ya</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="aktiv_pelayanant" name="aktiv_pelayanant">
                        <label class="form-check-label" for="aktiv_pelayanant">Tidak</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-check-label" for="pdp">Memahami dan Melaksanakan PDP?</label>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="pdp" name="pdp">
                        <label class="form-check-label" for="pdp">Ya</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="pdpt" name="pdpt">
                        <label class="form-check-label" for="pdpt">Tidak</label>
                    </div>
                </div>
                <div class="d-flex flex-column mb-3">
                    <div class="input-group">
                        <input type="file" class="form-control" id="sbm" name="sbm" aria-describedby="sertifikatHelp">
                        <label class="input-group-text" for="sbm" aria-describedby="sertifikatHelp">Upload</label>
                    </div>
                    <div id="sertifikatHelp" class="form-text">Mohon Upload Sertifikat Sebagai Bukti Pernah Mengikuti Student Bible Meeting</div>
                </div>
                <div class="mb-3">
                    <label class="form-check-label" for="organisasi">Tidak sedang menjabat sebagai ketua, sekretaris, dan bendahara pada organisasi intra kampus?</label>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="organisasi" name="organisasi">
                        <label class="form-check-label" for="organisasi">Ya</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="organisasit" name="organisasit">
                        <label class="form-check-label" for="organisasit">Tidak</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-check-label" for="muridkan">Dimuridkan dan memuridkan sekurang-kurangnya 2 bulan sebelum MMK berlangsung?</label>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="muridkan" name="muridkan">
                        <label class="form-check-label" for="muridkan">Ya</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="muridkant" name="muridkant">
                        <label class="form-check-label" for="muridkant">Tidak</label>
                    </div>
                </div>
                <div class="d-flex flex-column mb-3">
                    <div class="input-group">
                        <input type="file" class="form-control" id="krs" name="krs" aria-describedby="krsHelp">
                        <label class="input-group-text" for="krs">Upload</label>
                    </div>
                    <div id="krsHelp" class="form-text">Mohon Upload KRS Sebagai Bukti Aktif Kuliah (Minimal semester VI dan maksimal semester VIII)</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include('template/footer.php'); ?>

</html>