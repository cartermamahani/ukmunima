<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>
<div class="card bg-white border-primary contentCard">
  <div class="card-body">
    <div class="headerUKM col-12 d-flex align-items-center">
      <img src="<?= site_url('assets/doc/' . $ukmData['logo_ukm']) ?>" class="col-1" style="width: 5%;" />
      <h3 class="col-11 d-flex justify-content-center" style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; font-size: 20pt "> <?= $ukmData['nama_ukm'] ?> </h3>
    </div>
    <div class="d-flex justify-content-center col-12">
      <img src="<?= site_url('assets/doc/' . $ukmData['foto_struktur']) ?>" class="w-50" />
    </div>
    <br>
    <div class="col-12 text-center" style="font-family: sans-serif; font-size:12pt"><?= $ukmData['keterangan_ukm'] ?></div>
    <br>
    <div class="d-flex justify-content-center flex-column col-12">
      <div style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;" class="text-center">
        <h3> Visi </h3>
      </div>
      <div class="col-12 text-center" style="font-family: sans-serif; font-size:12pt"><?= $ukmData['visi'] ?></div>
    </div>
    <br>
    <div class="d-flex justify-content-center flex-column col-12">
      <div style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;" class="text-center">
        <h3> Misi </h3>
      </div>
      <div class="col-12 text-center" style="font-family: sans-serif; font-size:12pt"><?= $ukmData['misi'] ?></div>
    </div>
    <br>
    <div class="d-flex justify-content-center flex-column col-12">
      <div style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;" class="text-center">
        <h3> Contact Us </h3>
      </div>
      <h6 class="col-12 d-flex justify-content-center"><?= $ukmData['email'] ?></h6>
      <h6 class="col-12 d-flex justify-content-center"><?= $ukmData['nomor_hp'] ?></h6>
    </div>
  </div>
</div>
<?php include('template/footer.php'); ?>

</html>