<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>
<div class="card bg-white border-primary contentCard">
    <div class="card-body">
        <div class="fontbold">
            <h3 class="card-title text-center" style="font-size: 20pt;">PROGRAM KERJA UNIT KEGIATAN MAHASISWA</h3>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama UKM</th>
                    <th scope="col">Nama Bidang</th>
                    <th scope="col">Nama Progja</th>
                    <th scope="col">Tanggal Progja</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">File</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
                <?php foreach ($progjaData as $row) : ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= $row['nama_ukm'] ?></td>
                        <td><?= $row['nama_bidang'] ?></td>
                        <td><?= $row['nama_progja'] ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_progja'])) ?></td>
                        <td><?= $row['keterangan'] ?></td>
                        <td>
                            <a href="<?= base_url('download/' . $row['file_name']) ?>" target="_blank">
                                <i class="fas fa-file me-2"></i><?= $row['file_name'] ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include('template/footer.php'); ?>

</html>