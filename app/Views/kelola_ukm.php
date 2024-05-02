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

<div class="card bg-white border-primary contentCard">
    <div class="card-body">
        <h5 class="card-title"><?= $namaUkm ?></h5>
        <?php if (session()->get('userRole') == 1) : ?>
            <button type="button" class="btn btn-primary addData" data-bs-toggle="modal" data-bs-target="#addModal" data-ukm="<?= $namaUkm ?>">
                <i class="fas fa-plus"></i>Tambah UKM
            </button>
        <?php endif; ?>
        <table class="table table-bordered table-hover mt-3" id="editableTable">
            <thead>
                <tr>
                    <th scope="col">Nama UKM</th>
                    <th scope="col">Logo UKM</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Visi</th>
                    <th scope="col">Misi</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Kontak</th>
                    <th scope="col">Foto Struktur</th>
                    <th scope="col">Kelola</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Data as $row) : ?>
                    <tr>
                        <td data-field="nama_ukm"><?= $row['nama_ukm'] ?></td>
                        <td data-field="logo_ukm"><img src="<?= site_url('assets/doc/' . $row['logo_ukm']) ?>" width="5%" /></td>
                        <td data-field="keterangan"><?= $row['keterangan_ukm'] ?></td>
                        <td data-field="visi"><?= $row['visi'] ?></td>
                        <td data-field="misi"><?= $row['misi'] ?></td>
                        <td data-field="email"><?= $row['email'] ?></td>
                        <td data-field="nomor_hp"><?= $row['nomor_hp'] ?></td>
                        <td data-field="foto_struktur"><img src="<?= site_url('assets/doc/' . $row['foto_struktur']) ?>" width="5%" /></td>
                        <td>
                            <a class="button button-small edit me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $row['id_ukm'] ?>" data-nama="<?= $row['nama_ukm'] ?>" data-logo="<?= $row['logo_ukm'] ?>" data-email="<?= $row['email'] ?>" data-nomor_hp="<?= $row['nomor_hp'] ?>" data-foto_struktur="<?= $row['foto_struktur'] ?>" data-keterangan="<?= $row['keterangan_ukm'] ?>" data-visi="<?= $row['visi'] ?>" data-misi="<?= $row['misi'] ?>">
                                <i class="fas fa-pen"></i>
                            </a>
                            <?php if (session()->get('userRole') == 1) : ?>
                                <a class="button button-small btn-danger delete" title="Delete" data-id="<?= $row['id_ukm'] ?>" data-logo="<?= $row['logo_ukm'] ?>" data-foto_struktur="<?= $row['foto_struktur'] ?>" data-bs-toggle="modal" data-bs-target="#confirmDel">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php endif; ?>
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
                        <h5 class="modal-title" id="confirmDel">Hapus UKM?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin menghapus UKM ini?
                        <form id="deleteForm" action="<?= base_url('kelola_ukm/delete_ukm') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_ukm" id="id_ukm">
                            <input type="hidden" name="current_fileLogo" id="current_fileLogo">
                            <input type="hidden" name="current_fileStruktur" id="current_fileStruktur">
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
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit UKM</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" action="<?= base_url('kelola_ukm/update_ukm') ?>" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="id_ukm" id="id_ukm">
                            <input type="text" class="form-control mb-3" id="nama_ukm" name="nama_ukm">
                            <input type="text" class="form-control mb-3" placeholder="Input Tentang atau Sejarah Unit Kegiatan Mahasiswa" id="keterangan" name="keterangan">
                            <input type="text" class="form-control mb-3" placeholder="Input Visi Sejarah Unit Kegiatan Mahasiswa" id="keterangan" name="visi">
                            <input type="text" class="form-control mb-3" placeholder="Input Misi Sejarah Unit Kegiatan Mahasiswa" id="keterangan" name="misi">
                            <input type="text" class="form-control mb-3" placeholder="Input Email / Media Social" id="email" name="email">
                            <input type="text" class="form-control mb-3" placeholder="Input No. HP" id="nomor_hp" name="nomor_hp">
                            <input type="hidden" name="current_fileLogo" id="current_fileLogo">
                            <input type="hidden" name="current_fileStruktur" id="current_fileStruktur">
                            <div class="mb-3">
                                <label for="new_fileLogo" class="form-label">Logo UKM</label>
                                <input type="file" class="form-control mb-3" name="new_fileLogo" id="new_fileLogo" accept="image/png, image/gif, image/jpeg">
                            </div>
                            <div class="mb-3">
                                <label for="new_fileStruktur" class="form-label">Foto Struktur</label>
                                <input type="file" class="form-control mb-3" name="new_fileStruktur" id="new_fileStruktur" accept="image/png, image/gif, image/jpeg">
                            </div>
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
                        <h1 class="modal-title fs-5" id="addModalLabel">Tambah UKM</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="<?php echo base_url('kelola_ukm/add_ukm') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idUkm" id="idUkm" value="<?= session()->get('ukm') ?>">
                            <input type="text" class="form-control mb-3" placeholder="Nama UKM" id="nama_ukm" name="nama_ukm">
                            <input type="text" class="form-control mb-3" placeholder="Keterangan" id="keterangan" name="keterangan">
                            <input type="text" class="form-control mb-3" placeholder="Visi" id="Visi" name="visi">
                            <input type="text" class="form-control mb-3" placeholder="Misi" id="Visi" name="misi">
                            <input type="text" class="form-control mb-3" placeholder="E-mail" id="email" name="email">
                            <input type="text" class="form-control mb-3" placeholder="Kontak" id="nomor_hp" name="nomor_hp">
                            <div class="mb-3">
                                <label for="logo_ukm" class="form-label">Logo UKM</label>
                                <input type="file" class="form-control" id="logo_ukm" name="logo_ukm" accept="image/png, image/gif, image/jpeg" required>
                            </div>
                            <div class="mb-3">
                                <label for="foto_struktur" class="form-label">Foto Struktur</label>
                                <input type="file" class="form-control" id="foto_struktur" name="foto_struktur" accept="image/png, image/gif, image/jpeg" required>
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
            var current_fileLogo = button.data('logo');
            var current_fileStruktur = button.data('foto_struktur');

            var modal = $(this);
            modal.find('#id_ukm').val(id);
            modal.find('#current_fileLogo').val(current_fileLogo);
            modal.find('#current_fileStruktur').val(current_fileStruktur);
        });
    });
    $(document).ready(function() {
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal

            // Extract data attributes from the clicked button
            var id = button.data('id');
            var nama = button.data('nama');
            var email = button.data('email');
            var noHp = button.data('nomor_hp');
            var current_fileLogo = button.data('logo');
            var current_fileStruktur = button.data('foto_struktur');
            var tanggal = button.data('tanggal');
            var keterangan = button.data('keterangan');
            var keterangan = button.data('visi');
            var keterangan = button.data('misi');

            // Populate the modal form fields with the extracted data
            var modal = $(this);
            modal.find('#id_ukm').val(id);
            modal.find('#nama_ukm').val(nama);
            modal.find('#keterangan').val(keterangan);
            modal.find('#visi').val(keterangan);
            modal.find('#misi').val(keterangan);
            modal.find('#email').val(email);
            modal.find('#nomor_hp').val(noHp);
            modal.find('#current_fileLogo').val(current_fileLogo);
            modal.find('#current_fileStruktur').val(current_fileStruktur);
        });
    });

    $(document).ready(function() {
        var deleteId;

        $('.delete').click(function() {
            deleteId = $(this).data('id');
        });

        $('#deleteConfirmButton').click(function() {
            if (deleteId !== undefined) {
                $.ajax({
                    url: '/delete_ukm/' + deleteId,
                    method: 'POST',
                    success: function(response) {},
                    error: function() {}
                });
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include('template/footer.php'); ?>

</html>