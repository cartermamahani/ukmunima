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
            Berhasil!
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
        <div class="fontbold">
            <h3 class="card-title text-center" style="font-size: 20pt;">Calon Pengurus <?= $namaUkm ?></h3>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3" id="editableTable">
                <thead class="table-dark text-center">
                    <tr>
                        <?php if (session()->get('userRole') == 1) : ?>
                            <th scope="col">Nama UKM</th>
                        <?php endif; ?>
                        <th scope="col">Email</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Aktif Pelayanan</th>
                        <th scope="col">PDP</th>
                        <th scope="col">SBM</th>
                        <th scope="col">Organisasi</th>
                        <th scope="col">Muridkan</th>
                        <th scope="col">Aktif Kuliah</th>
                        <th scope="col">Skor</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Data as $row) : ?>
                        <tr>
                            <?php if (session()->get('userRole') == 1) : ?>
                                <td><?= $row['nama_ukm'] ?></td>
                            <?php endif; ?>
                            <td data-field="email"><?= $row['email'] ?></td>
                            <td data-field="nama"><?= $row['nama'] ?></td>

                            <td data-field="aktiv_pelayanan"><?php if ($row['aktiv_pelayanan'] == "1") : ?>YA <?php elseif ($row['pribadi'] == "0") : ?>TIDAK <?php endif;  ?></td>
                            <td data-field="pdp"><?php if ($row['pdp'] == "1") : ?>YA <?php elseif ($row['pdp'] == "0") : ?>TIDAK <?php endif; ?></td>
                            <td data-field="sbm" class="text-center">
                                <?php
                                $sbmFilePath = 'assets/doc/' . $row['sbm'];
                                $fileExtension = pathinfo($sbmFilePath, PATHINFO_EXTENSION);

                                if ($row['sbm'] == null) {
                                    echo '<i class="fas fa-times"></i>';
                                } else if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    echo '<img src="' . site_url($sbmFilePath) . '" width="25px" />';
                                } else {
                                    echo '<a href="' . base_url("kelola_pendaftaran_bpmk/download/" . $row['sbm']) . '" target="_blank"><i class="fas fa-file"></i></a>';
                                }
                                ?>

                            </td>
                            <td data-field="organisasi"><?php if ($row['organisasi']  == "1") : ?>YA <?php elseif ($row['organisasi'] == "0") : ?>TIDAK <?php endif;  ?></td>
                            <td data-field="muridkan"><?php if ($row['muridkan']  == "1") : ?>YA <?php elseif ($row['muridkan'] == "0") : ?>TIDAK <?php endif;  ?></td>
                            <td data-field="aktiv_kuliah" class="text-center">
                                <?php
                                $sbmFilePath = 'assets/doc/' . $row['aktiv_kuliah'];
                                $fileExtension = pathinfo($sbmFilePath, PATHINFO_EXTENSION);

                                if ($row['aktiv_kuliah'] == null) {
                                    echo '<i class="fas fa-times"></i>';
                                } else if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    echo '<img src="' . site_url($sbmFilePath) . '" width="25px" />';
                                } else {
                                    echo '<a href="' . base_url("kelola_pendaftaran_bpmk/download/" . $row['aktiv_kuliah']) . '" target="_blank"><i class="fas fa-file"></i></a>';
                                }
                                ?>
                            </td>
                            <td data-field="skor"><?= $row['skor'] ?></td>
                            <td>
                                <a class="button button-small acc me-2" title="Terima" data-id="<?= $row['id'] ?>" data-email="<?= $row['email'] ?>" data-nama="<?= $row['nama'] ?>" data-bs-toggle="modal" data-bs-target="#confirmAcc">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a class="button button-small delete me-2" title="Tolak" data-id="<?= $row['id'] ?>" data-email="<?= $row['email'] ?>" data-nama="<?= $row['nama'] ?>" data-bs-toggle="modal" data-bs-target="#confirmDel">
                                    <i class="fas fa-times"></i>
                                </a>
                                <a class="button button-small btn-danger delete" title="Delete" data-id="<?= $row['id'] ?>" data-email="<?= $row['email'] ?>" data-nama="<?= $row['nama'] ?>" data-bs-toggle="modal" data-bs-target="#confirmDell">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Confirmation Delete Modal -->
        <div class="modal fade" id="confirmDel" tabindex="-1" aria-labelledby="confirmDel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDel">Tolak Pendaftaran?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin menolak pendafataran ini?
                        <form id="deleteForm" action="<?= base_url('kelola_pendaftaran_bpmk/tolak') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="email" id="email">
                            <input type="hidden" name="nama" id="nama">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="deleteEntry">Tolak</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmAcc" tabindex="-1" aria-labelledby="confirmDel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDel">Terima Pendaftaran?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin menerima pendafataran ini?
                        <form id="terimaForm" action="<?= base_url('kelola_pendaftaran_bpmk/terima') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="email" id="email">
                            <input type="hidden" name="nama" id="nama">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="terimaEntry">Terima</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="confirmDell" tabindex="-1" aria-labelledby="confirmDell" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDell">Hapus Pendaftaran?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin menghapus pendaftar ini?
                        <form id="tolakForm" action="<?= base_url('kelola_pendaftaran_bpmk/delete_bpmk') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="idUkm" id="idUkm" value="<?= session()->get('ukm') ?>">
                            <input type="hidden" name="current_file" id="current_file">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="tolakEntry">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script>
    $(document).on("click", "#tolakEntry", function() {
        $('#tolakForm').submit();
    });
    $(document).on("click", "#deleteEntry", function() {
        $('#deleteForm').submit();
    });
    $(document).on("click", "#terimaEntry", function() {
        $('#terimaForm').submit();
    });
    $(document).ready(function() {
        $('#confirmDel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            var id = button.data('id');
            var email = button.data('email');
            var nama = button.data('nama');

            var modal = $(this);
            modal.find('#id').val(id);
            modal.find('#email').val(email);
            modal.find('#nama').val(nama);
        });
    });
    $(document).ready(function() {
        $('#confirmAcc').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var email = button.data('email');
            var nama = button.data('nama');

            var modal = $(this);
            modal.find('#id').val(id);
            modal.find('#email').val(email);
            modal.find('#nama').val(nama);
        });
    });
    $(document).ready(function() {
        $('#confirmDell').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var email = button.data('email');
            var nama = button.data('nama');

            var modal = $(this);
            modal.find('#id').val(id);
            modal.find('#email').val(email);
            modal.find('#nama').val(nama);

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
                $.ajax({
                    url: '/delete_bpmk/' + deleteId,
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