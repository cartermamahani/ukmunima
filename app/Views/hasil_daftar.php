<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>

<div class="card contentCard center" style="background-image:url(<?= base_url('assets/css/Audit.jpg'); ?>);display: flex;justify-content: center;align-items: center;">
    <?php if(session('status')=='success'): ?>
    <div class="bg-success" style="width: 50%; height: 20%; display: flex; justify-content: center;
    align-items: center; color: aliceblue; font-size: larger; font-weight: bold;">
        Terimakasih, Silahkan Cek Email Anda Secara Berkala Untuk Melihat Hasil Pendaftaran.
    </div>
    <?php elseif(session('status')=='error'): ?>
    <div class="bg-danger" style="width: 50%; height: 20%; display: flex; justify-content: center;
    align-items: center; color: aliceblue; font-size: larger; font-weight: bold;">
        Maaf, Pendaftaran Gagal. Silahkan Cek Kembali Formulir Anda.
    </div>
    <?php endif; ?>
</div>

<?php include('template/footer.php'); ?>

</html>