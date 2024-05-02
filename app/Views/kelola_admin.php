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
        <button type="button" class="btn btn-primary addData" data-bs-toggle="modal" data-bs-target="#addModal" data-ukm="<?= $namaUkm ?>">
            <i class="fas fa-plus"></i>Tambah UKM
        </button>
        <table class="table table-bordered table-hover mt-3" id="editableTable">
            <thead>
                <tr>
                    <th scope="col">Nama UKM</th>
                    <th scope="col">Nama Admin</th>
                    <th scope="col">UserName</th>
                    <th scope="col">Password Encrypted</th>
                    <th scope="col">Level Admin</th>
                    <th scope="col">Kelola</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Data as $row) : ?>
                    <tr>
                        <td data-field="nama_ukm"><?= $row['nama_ukm'] ?></td>
                        <td data-field="nama_admin"><?= $row['nama_admin'] ?></td>
                        <td data-field="username"><?= $row['username'] ?></td>
                        <td data-field="password">
                            <div class="input-group mb-3">
                                <input type="password" id="password-field<?= $row['id_admin'] ?>" class="form-control" value="<?= $row['password'] ?>" aria-label="Password" aria-describedby="basic-addon1" readonly>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" onclick="togglePasswordVisibility(this, <?= $row['id_admin'] ?>)">
                                        <i id="showPass<?= $row['id_admin'] ?>" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td data-field="level_admin"><?= $row['level_admin'] == 1 ? "Super Admin" : "Admin UKM" ?></td>
                        <td>
                            <a class="button button-small edit me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $row['id_admin'] ?>" data-id_ukm="<?= $row['id_ukm'] ?>" data-nama_ukm="<?= $row['nama_ukm'] ?>" data-nama_admin="<?= $row['nama_admin'] ?>" data-username="<?= $row['username'] ?>" data-password="<?= $row['password'] ?>" data-level_admin="<?= $row['level_admin'] ?>">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a class="button button-small btn-danger btn-danger delete" title="Delete" data-id="<?= $row['id_admin'] ?>" data-bs-toggle="modal" data-bs-target="#confirmDel">
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
                        <h5 class="modal-title" id="confirmDel">Hapus Admin?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin menghapus admin ini?
                        <form id="deleteForm" action="<?= base_url('kelola_admin/delete') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_admin" id="id_admin">
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
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Admin</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editForm" action="<?= base_url('kelola_admin/update') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_admin" id="id_admin">
                            <label for="nama_ukm">Nama UKM</label>
                            <input type="hidden" class="form-control mb-3" id="currentid_ukm" name="currentid_ukm">
                            <select class="custom-select" id="id_ukm" name="id_ukm">
                                <option selected class="selectedUKM"></option>
                                <?php foreach ($ukmNames as $ukm) : ?>
                                    <option value=<?= $ukm['id_ukm'] ?>><?= $ukm['nama_ukm'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="nama_ukm">Nama Admin</label>
                            <input type="text" class="form-control mb-3" id="nama_admin" name="nama_admin">
                            <label for="nama_ukm">Username</label>
                            <input type="text" class="form-control mb-3" id="username" name="username">
                            <label for="nama_ukm">Password</label>
                            <input type="hidden" class="form-control mb-3" id="currentPassword" name="currentPassword">
                            <input type="password" class="form-control mb-3" id="password" name="password">
                            <select class="custom-select" id="level_admin" name="level_admin">
                                <option selected>Pilih Level Admin</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Admin UKM</option>
                            </select>
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
                        <h1 class="modal-title fs-5" id="addModalLabel">Tambah Admin</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="<?php echo base_url('kelola_admin/add') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_admin" id="id_admin">
                            <label for="nama_ukm">Nama UKM</label>
                            <select class="custom-select" id="id_ukm" name="id_ukm">
                                <option selected>Pilih UKM</option>
                                <?php foreach ($ukmNames as $ukm) : ?>
                                    <option value="<?= $ukm['id_ukm'] ?>"><?= $ukm['nama_ukm'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="nama_ukm">Nama Admin</label>
                            <input type="text" class="form-control mb-3" id="nama_admin" name="nama_admin">
                            <label for="nama_ukm">Username</label>
                            <input type="text" class="form-control mb-3" id="username" name="username">
                            <label for="nama_ukm">Password</label>
                            <input type="password" class="form-control mb-3" id="password" name="password">
                            <div class="input-group mb-3">
                                <select class="custom-select" id="level_admin" name="level_admin">
                                    <option selected>Pilih Level Admin</option>
                                    <option value="1">Super Admin</option>
                                    <option value="2">Admin UKM</option>
                                </select>
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

            var modal = $(this);
            modal.find('#id_admin').val(id);
        });
    });
    $(document).ready(function() {
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal

            // Extract data attributes from the clicked button
            console.log(button.data())
            var id = button.data('id');
            var id_ukm = button.data('id_ukm');
            var nama_ukm = button.data('nama_ukm');
            var nama_admin = button.data('nama_admin');
            var username = button.data('username');
            var password = button.data('password');
            var level_admin = button.data('level_admin');

            // Populate the modal form fields with the extracted data
            var modal = $(this);
            modal.find('#id_admin').val(id);
            modal.find('#currentid_ukm').val(id_ukm);
            modal.find('.selectedUKM').text(nama_ukm);
            modal.find('#nama_admin').val(nama_admin);
            modal.find('#username').val(username);
            modal.find('#password').val(password);
            modal.find('#currentPassword').val(password);
            modal.find('#level_admin').val(level_admin);
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
                    url: '/delete/' + deleteId,
                    method: 'POST',
                    success: function(response) {},
                    error: function() {}
                });
            }
        });
    });

    function togglePasswordVisibility(button, id) {
        var passwordField = document.getElementById('password-field' + id);
        var showPass = document.getElementById('showPass' + id);

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            showPass.className = 'fas fa-eye-slash'
        } else {
            passwordField.type = 'password';
            showPass.className = 'fas fa-eye'
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include('template/footer.php'); ?>

</html>