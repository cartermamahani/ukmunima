<!doctype html>
<html lang="en">
  <?php include('template/header.php'); ?>
  <?php include('template/menu.php'); ?>
  <?php include('template/navbar.php'); ?>
    <div class="card bg-white border-primary contentCard">
      <div class="card-body">
          <h5 class="col-12 text-center"> <?= $ukmData['judul'] ?></h5>
        <div class="d-flex justify-content-center row">
        <img src="<?= site_url('assets/doc/' . $ukmData['file_name']) ?>" style="height: 300px; width:auto"/>
        </div>
        <div class="col-12"><?= $ukmData['keterangan_ukm'] ?></div>
        <div class="d-flex justify-content-center flex-column col-12 mt-3">
          <span class="col-12 d-flex justify-content-center"><?= $ukmData['keterangan'] ?></span>
        </div>
      </div>
    </div>
  <?php include('template/footer.php'); ?>
</html>