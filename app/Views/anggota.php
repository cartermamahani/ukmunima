<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>
<div class="card bg-white border-primary contentCard">
  <div class="card-body">
    <div class="fontbold">
      <h3 class="card-title text-center" style="font-size: 20pt;">DAFTAR ANGGOTA UNIT KEGIATAN MAHASISWA</h3>
    </div>
    <table class="table table-bordered">
      <thead class="table-dark text-center">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Mahasiswa</th>
          <th scope="col">NIM</th>
          <th scope="col">Fakultas</th>
          <th scope="col">Jurusan</th>
          <th scope="col">Alamat</th>
          <th scope="col">Tempat Lahir</th>
          <th scope="col">Tanggal Lahir</th>
          <th scope="col">Nama UKM</th>
        </tr>
      </thead>
      <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($dataAnggota as $row) : ?>
          <tr>
            <td><?= $counter++ ?></td>
            <td><?= $row['nama_mahasiswa'] ?></td>
            <td><?= $row['nim'] ?></td>
            <td><?= $row['fakultas'] ?></td>
            <td><?= $row['jurusan'] ?></td>
            <td><?= $row['alamat'] ?></td>
            <td><?= $row['tempat_lahir'] ?></td>
            <td><?= Date('d-m-Y', strtotime($source = $row['tanggal_lahir'])); ?></td>
            <td><?= $row['nama_ukm'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include('template/footer.php'); ?>

</html>