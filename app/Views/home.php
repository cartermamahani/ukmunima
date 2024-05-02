<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>
<?php if (session('status') == 'error') : ?>
  <div class="alert alert-warning" style="position: absolute; right: 0; top: 5rem">
    Username Atau Password Salah
  </div>
<?php endif; ?>
<br>

<div class="card contentCard center" style="background-image:url(<?= base_url('assets/css/Audittt.jpg'); ?>)">
  <div class="d-flex justify-content-center w-10 m-auto text-center">
    <!-- <div class="animasi-ketik" style="color: red;"> -->
    <h1 class="card-title mt-2 fontbold" style=" color: navi;"> PORTAL BERITA UNIT KEGIATAN MAHASISWA
      <br> UNIVERSITAS NEGERI MANADO
    </h1>
    <!-- </div> -->
  </div>
</div>
<br>

<div class="card bg-white contentCard center">
  <div class="card-body">
    <div class="fontbold">
      <h3 class="card-title d-flex justify-content-left mt-2" style="color: navy; font-size: 20pt;">TENTANG UNIT KEGIATAN MAHASISWA</h3>
    </div>
    <div class="d-flex justify-content-center w-30 m-auto" style="font-size: 12pt;">
      <span class="homeUKM text-left">
        Unit Kegiatan Mahasiswa (UKM) merupakan organisasi kemahasiswaan yang mempunyai tugas merencanakan, melaksanakan,
        dan mengembangkan kegiatan ekstrakulikuler kemahasiswaan yang bersifat penalaran, minat
        dan kegemaran, kesejahteraan, dan minat khusus sesuai dengan tugas dan tanggung jawabnya.
        Kedudukan wadah ini berada pada wilayah universitas yang secara aktif mengembangkan
        sistem pengelolaan organisasi secara mandiri.
      </span>
    </div>
    <br>
    <br>
    <div class="card border-white contentCard" style="background-color: navy;">
      <!-- <div class="divider"></div> -->
      <!-- Garis diatas -->
      <br>
      <div class="kegiatanList">
        <div class="berita">
          <h3 class="card-title d-flex justify-content-center">BERITA & UPDATE</h3>
          <div class="divider"></div>
        </div>
        <div class="container">
          <div class="row d-flex justify-content-center">
            <?php foreach ($Data as $row) : ?>
              <div class="card m-1" style="width: 20rem;">
                <img class="card-img-top" style="width: auto; height: 150px; object-fit: cover;" src="<?= site_url('assets/doc/' . $row['file_name']) ?>" alt="Foto Kegiatan">
                <div class="card-body">
                  <small><?= date('d-m-Y', strtotime($row['waktu'])) ?> / <?= $row['nama_ukm'] ?></small>
                  <h5 class="card-title"><?= $row['judul'] ?></h5>
                  <p class="card-text">
                    <?php
                    $maxKeteranganLength = 100; // Adjust this to your desired length
                    $keterangan = $row['keterangan'];

                    if (strlen($keterangan) > $maxKeteranganLength) {
                      $shortenedKeterangan = substr($keterangan, 0, $maxKeteranganLength) . "...";
                      echo $shortenedKeterangan;
                    } else {
                      echo $keterangan;
                    }
                    ?>
                  </p>
                  <a href="<?= base_url('kegiatan/' . $row['id']) ?>" class="btn btn-primary">Baca Selengkapnya</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <br>
      </div>
    </div>
    <br>
    <div class="fontbold">
      <h3 class="card-title d-flex justify-content-center mt-2" style="color: navy;">DAFTAR UNIT KEGIATAN MAHASISWA</h3>
    </div>
    <div class=" d-flex justify-content-center w-30 m-auto">
      <span class="homeUKM text-center">
        Di Universitas Negeri Manado terdapat beberapa Unit Kegiatan Mahasiswa (UKM) yang mewadahi minat dan kegemaran dari mahasiswa.
        <br>
        Antara lain, yaitu : UKM Nyong & Noni, UKM Biro Pelayanan Mahasiswa, UKM Paduan Suara Mahasiswa, UKM Resimen Mahasiswa, dll.
      </span>
    </div>
    <div class="container mt-4" style="width: 50rem; width:auto; object-fit: cover;">
      <div class="row d-flex justify-content-center w-10 m-auto">
        <div class="col-md-4">
          <div class="card" style="height: 550px;">
            <img src="assets/css/bpmk.png" class="card-img-top" alt="Logo BPMK" style="height: 400px; width:auto; object-fit: cover;">
            <!-- <br> -->
            <div class="card-body bg-primary">
              <h5 class="card-title">UNIT KEGIATAN MAHASISWA</h5>
              <p class="card-text">Biro Pelayanan Mahasiswa Kristen</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card" style="height: 550px;">
            <img src="assets/css/nnu.jpeg" class="card-img-top" alt="Logo NNU" style="height: 400px; width:auto">
            <!-- <br> -->
            <div class="card-body bg-primary">
              <h5 class="card-title">UNIT KEGIATAN MAHASISWA</h5>
              <p class="card-text">Nyong & Noni</p>
            </div>
          </div>
        </div>
        <!-- Tambahkan card lainnya sesuai kebutuhan -->
      </div>
    </div>
  </div>
</div>


<?php include('template/footer.php'); ?>

</html>