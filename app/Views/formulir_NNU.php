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
            <h3 class="card-title text-center" style="font-size: 20pt;">Formulir Pendaftaran Nyong dan Noni UNIMA</h3>
        </div>
        <div class="d-flex justify-content-center align-items-center w-100">
            <form class="w-50 " id="daftar" action="<?= base_url('daftar_nnu') ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <div class="d-flex flex-column mb-3">
                    <div class="input-group">
                        <input type="file" class="form-control" id="mahasiswa_aktif" name="mahasiswa_aktif" aria-describedby="krsHelp">
                        <label class="input-group-text" for="mahasiswa_aktif" aria-describedby="sertifikatHelp">Upload</label>
                    </div>
                    <div id="krsHelp" class="form-text">Mohon Upload KRS Sebagai Bukti Mahasiswa Aktif UNIMA</div>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="text" class="form-control" id="semester" name="semester">
                </div>
                <div class="mb-3">
                    <label class="form-check-label">Berkepribadian Baik?</label>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="pribadi" name="pribadi">
                        <label class="form-check-label" for="pribadi">Ya</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="pribadit" name="pribadit">
                        <label class="form-check-label" for="pribadit">Tidak</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-check-label" for="wawasan">Berwawasan Luas?</label>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="wawasan" name="wawasan">
                        <label class="form-check-label" for="wawasan">Ya</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="wawasant" name="wawasant">
                        <label class="form-check-label" for="wawasant">Tidak</label>
                    </div>
                </div>
                <div class="d-flex flex-column mb-3">
                    <div class="input-group">
                        <input type="file" class="form-control" id="penampilan" name="penampilan" aria-describedby="penampilanHelp">
                        <label class="input-group-text" for="penampilan" aria-describedby="sertifikatHelp">Upload</label>
                    </div>
                    <div id="penampilanHelp" class="form-text">Mohon Upload Foto Diri</div>
                </div>
                <div class="mb-3">
                    <label for="bahasa_asing" class="form-label">Bahasa Asing</label>
                    <input type="text" class="form-control" id="bahasa_asing" name="bahasa_asing">
                </div>
                <div class="mb-3">
                    <label class="form-check-label" for="belum_menikah">Belum Menikah?</label>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="belum_menikah" name="belum_menikah">
                        <label class="form-check-label" for="belum_menikah">Ya</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="belum_menikaht" name="belum_menikaht">
                        <label class="form-check-label" for="belum_menikaht">Tidak</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="custom-select" id="jenis_kelamin" name="jenis_kelamin">
                        <option selected>Pilih Jenis Kelamin</option>
                        <option value="Perempuan">Perempuan</option>
                        <option value="Laki-laki">Laki-laki</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tinggi" class="form-label">Tinggi Badan (cm)</label>
                    <input type="text" class="form-control" id="tinggi" name="tinggi">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include('template/footer.php'); ?>

</html>