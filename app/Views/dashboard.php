<!doctype html>
<html lang="en">
  <?php include('template/header.php'); ?>
  <?php include('template/menu.php'); ?>
  <?php include('template/navbar.php'); ?>
    <div class="card bg-white border-primary contentCard">
      <div class="card-body">
        <h5 class="card-title d-flex justify-content-center">Selamat Datang, <?= $nama_admin ?></h5>
        <div class="d-flex justify-content-center align-items-end gap-5 row-gap-0 grid dashboardBtn h-75 row">
          <a type="button" href="<?php echo base_url('kelola_prestasi/' . $id_ukm) ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola Prestasi"><i class="fas fa-trophy"></i> Kelola Prestasi</a>
          <a type="button" href="<?php echo base_url('kelola_anggota/' . $id_ukm) ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola Anggota"><i class="fas fa-id-card"></i> Kelola Anggota</a>
          <a type="button" href="<?php echo base_url('kelola_lpj/' . $id_ukm) ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola LPJ"><i class="fas fa-file-invoice"></i> Kelola LPJ</a>
          <a type="button" href="<?php echo base_url('kelola_progja/' . $id_ukm) ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola ProgJa"><i class="fas fa-sitemap"></i> Kelola Progja</a>
          <a type="button" href="<?php echo base_url('kelola_dokumentasi/' . $id_ukm) ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola Dokumentasi"><i class="fas fa-book"></i> Kelola Dokumentasi</a>
          <a type="button" href="<?php echo base_url('kelola_kegiatan/' . $id_ukm) ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola Kegiatan"><i class="fas fa-calendar-plus"></i> Kelola Kegiatan</a>
          <a type="button" href="<?php echo base_url('kelola_ukm/' . $id_ukm) ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola Halaman UKM"><i class="fas fa-house-user"></i> Kelola Halaman UKM</a>
          <?php if($id_ukm == 1): ?>
          <a type="button" href="<?php echo base_url('kelola_pendaftaran_bpmk') ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola Calon Pengurus"><i class="fas fa-users-cog"></i> Kelola Calon Pengurus BPMK</a>
          <?php endif; ?>
          <?php if($id_ukm == 2): ?>
          <a type="button" href="<?php echo base_url('kelola_pendaftaran_nnu') ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola Calon Pengurus"><i class="fas fa-users-cog"></i> Kelola Calon Pengurus NNU</a>
          <?php endif; ?>

          <?php if(session()->get('userRole') == 1): ?>
          <a type="button" href="<?php echo base_url('kelola_admin') ?>" class="btn btn-primary d-flex align-items-center justify-content-center" data-toggle="tooltip" data-bs-placement="bottom" title="Kelola Admin UKM"><i class="fas fa-users-cog"></i> Kelola Admin UKM</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
    
  <?php include('template/footer.php'); ?>
</html>