<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="addSuccessToast" class="toast <?php echo session('status') == 'success' ? 'show' : 'hide' ?>" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Eksekusi Berhasil!
        </div>
    </div>
    <?php session()->remove('status'); ?>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="addFailToast" class="toast <?php echo session('status') == 'error' ? 'show' : 'hide' ?>" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Gagal</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Terjadi Kesalahan. Mohon Segarkan Halaman
        </div>
    </div>
    <?php session()->remove('status'); ?>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="downloadFail" class="toast <?php echo session('status') == 'dlerror' ? 'show' : 'hide' ?>" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Gagal</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Terjadi Kesalahan. Mohon Segarkan Halaman
        </div>
    </div>
    <?php session()->remove('status'); ?>
</div>

<div class="card bg-white border-primary contentCard">
    <div class="card-body">
        <h5 class="card-title">LPJ <?= $namaUkm ?></h5>
        <button type="button" class="btn btn-primary addData" data-bs-toggle="modal" data-bs-target="#addModal" data-ukm="<?= $namaUkm ?>">
            <i class="fas fa-plus"></i>Tambah LPJ
        </button>
        <table class="table table-bordered table-hover mt-3" id="editableTable">
            <thead>
                <tr>
                    <?php if (session()->get('userRole') == 1) : ?>
                        <th scope="col">Nama UKM</th>
                    <?php endif; ?>
                    <th scope="col">Nama Bidang</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Tanggal Periode</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">File LPJ</th>
                    <th scope="col">Kelola</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Data as $row) : ?>
                    <tr>
                        <?php if (session()->get('userRole') == 1) : ?>
                            <td><?= $row['nama_ukm'] ?></td>
                        <?php endif; ?>
                        <td data-field="nama_bidang"><?= $row['nama_bidang'] ?></td>
                        <td data-field="judul"><?= $row['judul'] ?></td>
                        <td data-field="tanggal_periode_lpj"><?= date('d-m-Y', strtotime($row['tanggal_periode_lpj'])) ?></td>
                        <td data-field="keterangan"><?= $row['keterangan'] ?></td>
                        <td data-field="file">
                            <a href="<?= base_url('kelola_lpj/download/' . $row['file_name']) ?>" target="_blank">
                                <i class="fas fa-file me-2"></i><?= $row['file_name'] ?>
                            </a>
                        </td>
                        <td>
                            <a class="button button-small edit me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $row['id_lpj'] ?>" data-id_ukm="<?= $row['id_ukm'] ?>" data-bidang="<?= $row['nama_bidang'] ?>" data-judul="<?= $row['judul'] ?>" data-file="<?= $row['file_name'] ?>" data-tanggal="<?= date('Y-m-d', strtotime($row['tanggal_periode_lpj'])) ?>" data-keterangan="<?= $row['keterangan'] ?>">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a class="button button-small btn-danger delete" title="Delete" data-id="<?= $row['id_lpj'] ?>" data-file="<?= $row['file_name'] ?>" data-bs-toggle="modal" data-bs-target="#confirmDel">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Confirmation Delete Modal -->
        <div class="modal fade" id="confirmDel" tabindex="-1" aria-labelledby="confirmDel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDel">Hapus LPJ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin menghapus LPJ ini?
                        <form id="deleteForm" action="<?= base_url('kelola_lpj/delete_lpj') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_lpj" id="id_lpj">
                            <input type="hidden" name="idUkm" id="idUkm" value="<?= session()->get('ukm') ?>">
                            <input type="hidden" name="current_file" id="current_file">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="deleteEntry">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit LPJ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" action="<?= base_url('kelola_lpj/update_lpj') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_lpj" id="id_lpj">
                            <input type="hidden" name="idUkm" id="idUkm" value="<?= session()->get('ukm') ?>">
                            <input type="text" class="form-control mb-3" name="nama_bidang" id="nama_bidang">
                            <input type="text" class="form-control mb-3" id="judul" name="judul">
                            <input type="date" class="form-control mb-3" id="edittanggal_periode_lpj" name="tanggal_periode_lpj">
                            <input type="text" class="form-control mb-3" id="keterangan" name="keterangan">
                            <input type="hidden" name="current_file" id="current_file">
                            <input type="file" class="form-control mb-3" name="new_file" id="new_file" accept=".pdf, .doc, .docx">
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
                        <h1 class="modal-title fs-5" id="addModalLabel">Tambah LPJ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="<?php echo base_url('kelola_lpj/add_lpj') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idUkm" id="idUkm" value="<?= session()->get('ukm') ?>">
                            <?php if (session()->get('userRole') == 1) : ?>
                                <select class="custom-select" id="id_ukm" name="id_ukm">
                                    <option selected>Pilih UKM</option>
                                    <?php foreach ($ukmNames as $ukm) : ?>
                                        <option value="<?= $ukm['id_ukm'] ?>"><?= $ukm['nama_ukm'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                            <input type="text" class="form-control mb-3" placeholder="Nama Bidang" id="nama_bidang" name="nama_bidang" required>
                            <input type="text" class="form-control mb-3" placeholder="Judul" id="judul" name="judul" required>
                            <input type="date" class="form-control mb-3" placeholder="Tanggal Periode" id="tanggal_periode_lpj" name="tanggal_periode_lpj" required>
                            <input type="text" class="form-control mb-3" placeholder="Keterangan" id="keterangan" name="keterangan">
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Choose File</label>
                                <input type="file" class="form-control" id="fileInput" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                            </div>
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
    $(document).on("click", "#deleteEntry", function() {
        $('#deleteForm').submit();
    });
    $(document).ready(function() {
        $('#confirmDel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            var id = button.data('id');
            var current_file = button.data('file');

            var modal = $(this);
            modal.find('#id_lpj').val(id);
            modal.find('#current_file').val(current_file);
        });
    });
    $(document).ready(function() {
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal

            // Extract data attributes from the clicked button
            var id = button.data('id');
            var id_ukm = button.data('id_ukm');
            var bidang = button.data('bidang');
            var judul = button.data('judul');
            var current_file = button.data('file');
            var tanggal = button.data('tanggal');
            var keterangan = button.data('keterangan');

            // Populate the modal form fields with the extracted data
            var modal = $(this);
            modal.find('#id_lpj').val(id);
            modal.find('#idUkm').val(id_ukm);
            modal.find('#nama_bidang').val(bidang);
            modal.find('#judul').val(judul);
            modal.find('#current_file').val(current_file);
            modal.find('#edittanggal_periode_lpj').val(tanggal);
            modal.find('#keterangan').val(keterangan);
        });
    });


    const addSuccessToast = document.getElementById('addSuccessToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(addSuccessToast)

    toastBootstrap.show()

    $(document).ready(function() {
        var deleteId;

        $('.delete').click(function() {
            deleteId = $(this).data('id');
        });

        $('#deleteConfirmButton').click(function() {
            if (deleteId !== undefined) {
                // Perform the actual delete action using AJAX
                $.ajax({
                    url: '/delete_lpj/' + deleteId, // Replace with your delete URL
                    method: 'POST',
                    success: function(response) {
                        // Handle success response (e.g., show toast)
                        // Refresh the page or update the table after successful delete
                        // ...
                    },
                    error: function() {
                        // Handle error (e.g., show toast)
                        // ...
                    }
                });
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include('template/footer.php'); ?>

</html>