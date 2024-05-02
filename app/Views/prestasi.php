<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>
<div class="card bg-white border-primary contentCard">
  <div class="card-body">
    <div class="fontbold">
      <h3 class="card-title text-center" style="font-size: 20pt;">PRESTASI UNIT KEGIATAN MAHASISWA</h3>
    </div>
    <table class="table table-bordered" style="font-size: 12pt;">
      <thead class="table-dark text-center">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama UKM</th>
          <th scope="col">Nama Prestasi</th>
          <th scope="col">Tanggal Prestasi</th>
        </tr>
      </thead>
      <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($prestasiData as $row) : ?>
          <tr>
            <td><?= $counter++ ?></td>
            <td><?= $row['nama_ukm'] ?></td>
            <td><?= $row['nama_prestasi'] ?></td>
            <td><?= Date('d-m-Y', strtotime($source = $row['tanggal_prestasi'])); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include('template/footer.php'); ?>

</html>