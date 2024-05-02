<!doctype html>
<html lang="en">
<?php include('template/header.php'); ?>
<?php include('template/menu.php'); ?>
<?php include('template/navbar.php'); ?>

<!-- <head>
    <title>Hasil Pemilihan Calon Pengurus UKM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head> -->

<div class="card bg-white border-primary contentCard">
    <div class="card-body">
        <div class="container mt-5">

            <!-- Tampilan Hasil Seleksi Pengurus UKM -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hasil_seleksi as $pengurus) : ?>
                        <tr>
                            <td><?php echo $pengurus['nama']; ?></td>
                            <td><?php echo $pengurus['nim']; ?></td>
                            <td><?php echo $pengurus['skor']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php include('template/footer.php'); ?>

</html>