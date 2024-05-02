<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>
<div class="card bg-white border-primary contentCard">
  <div class="card-body">
    <div class="fontbold">
      <h3 class="card-title text-center" style="font-size: 20pt;">DOKUMENTASI UNIT KEGIATAN MAHASISWA</h3>
    </div>
    <table class="table table-bordered">
      <thead class="table-dark text-center" style="font-family: sans-serif; font: size 10px;">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama UKM</th>
          <th scope=" col">Tanggal Dokumentasi</th>
          <th scope=" col">Image</th>
          <th scope="col">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($dokumentasiData as $row) : ?>
          <tr>
            <td><?= $counter++ ?></td>
            <td><?= $row['nama_ukm'] ?></td>
            <td><?= $row['tanggal_dokumentasi'] ?></td>
            <td align="center"><img src="<?= site_url('assets/doc/' . $row['file_name']) ?>" width="30%" /></td>
            <td><?= $row['keterangan'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include('template/footer.php'); ?>

</html>