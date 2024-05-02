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

<div class="card bg-white border-primary contentCard d-flex justify-content-center w-30 m-auto">
    <div class="card-body">
        <div class="fontbold">
            <h3 class="card-title text-center" style="font-size: 20pt;">Calon Pengurus <?= $namaUkm ?></h3>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3" id="editableTable">
                <thead>
                    <tr>
                        <?php if (session()->get('userRole') == 1) : ?>
                            <th scope="col">Nama UKM</th>
                        <?php endif; ?>
                        <th scope="col">Email</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Mahasiswa Aktif</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Berkepribadian Baik</th>
                        <th scope="col">Berwawasan Luas</th>
                        <th scope="col">Berpenampilan Menarik</th>
                        <th scope="col">Bahasa Asing</th>
                        <th scope="col">Belum Menikah</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Tinggi Badan (cm)</th>
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
                            <td data-field="mahasiswa_aktif" class="text-center">
                                <?php
                                $sbmFilePath = 'assets/doc/' . $row['mahasiswa_aktif'];
                                $fileExtension = pathinfo($sbmFilePath, PATHINFO_EXTENSION);

                                if ($row['mahasiswa_aktif'] == null) {
                                    echo '<i class="fas fa-times"></i>';
                                } else if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    echo '<img src="' . site_url($sbmFilePath) . '" width="25px" />';
                                } else {
                                    echo '<a href="' . base_url("kelola_pendaftaran_nnu/download/" . $row['mahasiswa_aktif']) . '" target="_blank"><i class="fas fa-file"></i></a>';
                                }
                                ?>
                            </td>
                            <td data-field="semester"><?= $row['semester'] ?></td>
                            <td data-field="pribadi"><?php if ($row['pribadi'] == "1") : ?>YA <?php elseif ($row['pribadi'] == "0") : ?>TIDAK <?php endif; ?></td>
                            <td data-field="wawasan"><?php if ($row['wawasan'] == "1") : ?>YA <?php elseif ($row['pribadi'] == "0") : ?>TIDAK <?php endif; ?> </td>
                            <td data-field="penampilan" class="text-center">
                                <?php
                                $sbmFilePath = 'assets/doc/' . $row['mahasiswa_aktif'];
                                $fileExtension = pathinfo($sbmFilePath, PATHINFO_EXTENSION);

                                if ($row['mahasiswa_aktif'] == null) {
                                    echo '<i class="fas fa-times"></i>';
                                } else {
                                    echo '<img src="' . site_url("assets/doc/" . $row['penampilan']) . '" width="25px" />';
                                }

                                ?>
                            </td>
                            <td data-field="bahasa_asing"><?= $row['bahasa_asing'] ?></td>
                            <td data-field="belum_menikah"><?php if ($row['belum_menikah']  == "1") : ?>YA <?php elseif ($row['pribadi'] == "0") : ?>TIDAK <?php endif; ?></td>
                            <td data-field="jenis_kelamin"><?= $row['jenis_kelamin'] ?></td>
                            <td data-field="tinggi"><?= $row['tinggi'] ?></td>
                            <td data-field="skor"><?= $row['skor'] ?></td>
                            <td>
                                <a class="button button-small acc me-2" title="Terima" data-id="<?= $row['id'] ?>" data-email="<?= $row['email'] ?>" data-nama="<?= $row['nama'] ?>" data-bs-toggle="modal" data-bs-target="#confirmAcc">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a class="button button-small delete" title="Tolak" data-id="<?= $row['id'] ?>" data-email="<?= $row['email'] ?>" data-nama="<?= $row['nama'] ?>" data-bs-toggle="modal" data-bs-target="#confirmDel">
                                    <i class="fas fa-times"></i>
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
                        <form id="deleteForm" action="<?= base_url('kelola_pendaftaran_nnu/tolak') ?>" method="post" enctype="multipart/form-data">
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
                        <form id="terimaForm" action="<?= base_url('kelola_pendaftaran_nnu/terima') ?>" method="post" enctype="multipart/form-data">
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

    </div>
</div>


<script>
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
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include('template/footer.php'); ?>

</html>