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
        <h5 class="card-title">Prestasi <?= $namaUkm ?></h5>
        <button type="button" class="btn btn-primary addData" data-bs-toggle="modal" data-bs-target="#addModal" data-ukm="<?= $namaUkm ?>">
            <i class="fas fa-plus"></i>Tambah Prestasi
        </button>
        <table class="table table-bordered table-hover mt-3" id="editableTable">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <?php if (session()->get('userRole') == 1) : ?>
                        <th scope="col">Nama UKM</th>
                    <?php endif; ?>
                    <th scope="col">Nama Prestasi</th>
                    <th scope="col">Tanggal Prestasi</th>
                    <th scope="col">Kelola</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
                <?php foreach ($prestasiData as $row) : ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <?php if (session()->get('userRole') == 1) : ?>
                            <td><?= $row['nama_ukm'] ?></td>
                        <?php endif; ?>
                        <td data-field="prestasi"><?= $row['nama_prestasi'] ?></td>
                        <td data-field="tanggal"><?= date('d-m-Y', strtotime($row['tanggal_prestasi'])) ?></td>
                        <td>
                            <a class="button button-small edit me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $row['id_prestasi'] ?>" data-tanggal="<?= $row['tanggal_prestasi'] ?>">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a class="button button-small btn-danger delete" title="Delete" data-id="<?= $row['id_prestasi'] ?>">
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
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Prestasi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" action="<?= base_url('kelola_prestasi/update_prestasi') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="editRowId" name="id">
                            <input type="hidden" id="rowIndex">
                            <input type="text" class="form-control mb-3" placeholder="Nama Prestasi" id="editNamaPrestasi" name="nama_prestasi">
                            <input type="date" class="form-control mb-3" placeholder="Pilih Tanggal" id="editTanggalPrestasi" name="tanggal_prestasi">
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
                        <h1 class="modal-title fs-5" id="addModalLabel">Tambah Prestasi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="<?php echo base_url('kelola_prestasi/add_prestasi') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="addNamaUkm" name="nama_ukm" value="<?= $namaUkm ?>">
                            <?php if (session()->get('userRole') == 1) : ?>
                                <select class="custom-select" id="nama_ukmAdmin" name="nama_ukmAdmin">
                                    <option selected>Pilih UKM</option>
                                    <?php foreach ($ukmNames as $ukm) : ?>
                                        <option value="<?= $ukm['nama_ukm'] ?>"><?= $ukm['nama_ukm'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                            <input type="text" class="form-control mb-3" placeholder="Nama Prestasi" id="addNamaPrestasi" name="nama_prestasi">
                            <input type="date" class="form-control mb-3" placeholder="Pilih Tanggal" id="addTanggalPrestasi" name="tanggal_prestasi">
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
<script src="<?= base_url('assets/js/editable.js') ?>"></script>
<?php include('template/footer.php'); ?>

</html>