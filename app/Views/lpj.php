<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>
<div class="card bg-white border-primary contentCard">
    <div class="card-body">
        <div class="fontbold">
            <h3 class="card-title text-center" style="font-size: 20pt;">LAPORAN PERTANGGUNG JAWABAN</h3>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama UKM</th>
                    <th scope="col">Nama Bidang</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Tanggal Periode</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">File LPJ</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
                <?php foreach ($lpjData as $row) : ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= $row['nama_ukm'] ?></td>
                        <td><?= $row['nama_bidang'] ?></td>
                        <td><?= $row['judul'] ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_periode_lpj'])) ?></td>
                        <td><?= $row['keterangan'] ?></td>
                        <td>
                            <a href="<?= base_url('kelola_lpj/download/' . $row['file_name']) ?>" target="_blank">
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