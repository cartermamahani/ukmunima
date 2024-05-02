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
    <div id="deleteSuccessToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Hapus Data Berhasil!
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

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="editSuccessToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Ubah Data Berhasil!
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="editFailToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Gagal</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Gagal Mengubah Data! Mohon Segarkan Halaman
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="addFailToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Gagal</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Gagal Menambah Data! Mohon Segarkan Halaman
        </div>
    </div>
</div>

<div class="card bg-white border-primary contentCard">
    <div class="card-body">
        <h5 class="card-title">Anggota <?= $namaUkm ?></h5>
        <button type="button" class="btn btn-primary addData" data-bs-toggle="modal" data-bs-target="#addModal" data-ukm="<?= $namaUkm ?>">
            <i class="fas fa-plus"></i>Tambah Anggota
        </button>
        <table class="table table-bordered table-hover mt-3" id="editableTable">
            <thead>
                <tr>
                    <?php if (session()->get('userRole') == 1) : ?>
                        <th scope="col">Nama UKM</th>
                    <?php endif; ?>
                    <th scope="col">NIM</th>
                    <th scope="col">Nama Mahasiswa</th>
                    <th scope="col">Fakultas</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tempat Lahir</th>
                    <th scope="col">Tanggal Lahir</th>
                    <th scope="col">Kelola</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
                <?php foreach ($prestasiData as $row) : ?>
                    <tr>
                        <?php if (session()->get('userRole') == 1) : ?>
                            <td><?= $row['nama_ukm'] ?></td>
                        <?php endif; ?>
                        <td data-field="nim"><?= $row['nim'] ?></td>
                        <td data-field="nama_mahasiswa"><?= $row['nama_mahasiswa'] ?></td>
                        <td data-field="fakultas"><?= $row['fakultas'] ?></td>
                        <td data-field="jurusan"><?= $row['jurusan'] ?></td>
                        <td data-field="alamat"><?= $row['alamat'] ?></td>
                        <td data-field="tempat_lahir"><?= $row['tempat_lahir'] ?></td>
                        <td data-field="tanggal_lahir"><?= date('d-m-Y', strtotime($row['tanggal_lahir'])) ?></td>
                        <td>
                            <a class="button button-small edit me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $row['id_anggota'] ?>" data-tanggal="<?= $row['tanggal_lahir'] ?>">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a class="button button-small btn-danger delete" title="Delete" data-id="<?= $row['id_anggota'] ?>">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Anggota</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" action="<?= base_url('kelola_anggota/update_anggota') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="editRowId" name="id">
                            <input type="hidden" id="rowIndex">
                            <input type="text" class="form-control mb-3" placeholder="NIM" id="editNim" name="nim">
                            <input type="text" class="form-control mb-3" placeholder="Nama Mahasiswa" id="editNamaMahasiswa" name="nama_mahasiswa">
                            <input type="text" class="form-control mb-3" placeholder="Fakultas" id="editFakultas" name="fakultas">
                            <input type="text" class="form-control mb-3" placeholder="Jurusan" id="editJurusan" name="jurusan">
                            <input type="text" class="form-control mb-3" placeholder="Alamat" id="editAlamat" name="alamat">
                            <input type="text" class="form-control mb-3" placeholder="Tempat Lahir" id="editTempatLahir" name="tempat_lahir">
                            <input type="date" class="form-control mb-3" placeholder="Pilih Tanggal" id="editTanggalLahir" name="tanggal_lahir">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="saveEdit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Tambah Anggota</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="<?php echo base_url('kelola_anggota/add_anggota') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="idUkm" name="idUkm" value="<?= session()->get('ukm') ?>">
                            <?php if (session()->get('userRole') == 1) : ?>
                                <select class="custom-select" id="id_ukm" name="id_ukm">
                                    <option selected>Pilih UKM</option>
                                    <?php foreach ($ukmNames as $ukm) : ?>
                                        <option value="<?= $ukm['id_ukm'] ?>"><?= $ukm['nama_ukm'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                            <input type="text" class="form-control mb-3" placeholder="NIM" id="addNim" name="nim">
                            <input type="text" class="form-control mb-3" placeholder="Nama Mahasiswa" id="addNamaMahasiswa" name="nama_mahasiswa">
                            <input type="text" class="form-control mb-3" placeholder="Fakultas" id="addFakultas" name="fakultas">
                            <input type="text" class="form-control mb-3" placeholder="Jurusan" id="addJurusan" name="jurusan">
                            <input type="text" class="form-control mb-3" placeholder="Alamat" id="addAlamat" name="alamat">
                            <input type="text" class="form-control mb-3" placeholder="Tempat Lahir" id="addTempatLahir" name="tempat_lahir">
                            <input type="date" class="form-control mb-3" placeholder="Pilih Tanggal" id="addTanggalLahir" name="tanggal_lahir">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="addData" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).on("click", "#addData", function() {
        $('#addForm').submit();
    });
    $(document).on("click", "#saveEdit", function() {
        $('#editForm').submit();
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('assets/js/editableAnggota.js') ?>"></script>
<?php include('template/footer.php'); ?>

</html>