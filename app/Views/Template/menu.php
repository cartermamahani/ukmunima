<body>
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="background-color: navy;">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="d-flex flex-column align-items-center mb-4">
        <img src="<?= base_url('assets/css/unima_logo.png') ?>" class="w-50" style="background-color: white;border-radius: 50%;border: 7px solid white;" />
      </div>
      <div class="dropdown mt-5">
        <ul class="nav flex-column">
          <?php if (session('isLoggedIn')) : ?>
            <li class="nav-item" style="font-family: sans-serif; font-size:12pt">
              <a class="nav-link dropdown-item <?= session('isLoggedIn') ? 'active' : '' ?>" data-bs-toggle="collapse" href="#dashboardMenu" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-users-cog me-2" style="width: 2rem"></></i>Admin Menu</a>
              <div class="collapse" id="dashboardMenu">
                <div class="card card-body">
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'dashboard' ? 'active' : '' ?>" href="<?= uri_string() === 'dashboard' ? '#' : base_url('dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'kelola_prestasi/' . session('ukm') ? 'active' : '' ?>" href="<?= uri_string() === 'kelola_prestasi/' . session('ukm') ? '#' : base_url('kelola_prestasi/' . session('ukm')) ?>">Kelola Prestasi</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'kelola_anggota/' . session('ukm') ? 'active' : '' ?>" href="<?= uri_string() === 'kelola_anggota/' . session('ukm') ? '#' : base_url('kelola_anggota/' . session('ukm')) ?>">Kelola Anggota</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'kelola_lpj/' . session('ukm') ? 'active' : '' ?>" href="<?= uri_string() === 'kelola_lpj/' . session('ukm') ? '#' : base_url('kelola_lpj/' . session('ukm')) ?>">Kelola LPJ</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'kelola_progja/' . session('ukm') ? 'active' : '' ?>" href="<?= uri_string() === 'kelola_progja/' . session('ukm') ? '#' : base_url('kelola_progja/' . session('ukm')) ?>">Kelola Progja</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'kelola_dokumentasi/' . session('ukm') ? 'active' : '' ?>" href="<?= uri_string() === 'kelola_dokumentasi/' . session('ukm') ? '#' : base_url('kelola_dokumentasi/' . session('ukm')) ?>">Kelola Dokumentasi</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'kelola_kegiatan/' . session('ukm') ? 'active' : '' ?>" href="<?= uri_string() === 'kelola_kegiatan/' . session('ukm') ? '#' : base_url('kelola_kegiatan/' . session('ukm')) ?>">Kelola Kegiatan</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'kelola_halaman_ukm/' . session('ukm') ? 'active' : '' ?>" href="<?= uri_string() === 'kelola_halaman_ukm/' . session('ukm') ? '#' : base_url('kelola_ukm/' . session('ukm')) ?>">Kelola Halaman UKM</a>
                    </li>
                    <?php if (session()->get('userRole') == 1) : ?>
                      <li class="nav-item">
                        <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'kelola_admin' ? 'active' : '' ?>" href="<?= uri_string() === 'kelola_admin' ? '#' : base_url('kelola_admin') ?>">Kelola Admin</a>
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link dropdown-item <?= uri_string() === '' ? 'active' : '' ?>" href="<?= uri_string() === '' ? '#' : base_url() ?>" aria-current="true"><i class="fas fa-house-user me-2" aria-current="true" style="width: 2rem"></></i>Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link dropdown-item <?= strpos(uri_string(), 'home/showUkm') === 0 ? 'active' : '' ?>" data-bs-toggle="collapse" href="#collapseThis" role="button" aria-expanded="<?= strpos(uri_string(), 'home/showUkm') === 0 ? 'true' : 'false' ?>" aria-controls="collapseExample"><i class="fas fa-university me-2" style="width: 2rem"></></i>UKM</a>
            <div class="collapse <?= strpos(uri_string(), 'home/showUkm') === 0 ? 'show' : '' ?>" id="collapseThis">
              <div class="card card-body">
                <ul class="nav flex-column">
                  <?php foreach ($ukmNames as $ukm) : ?>
                    <li class="nav-item">
                      <a class="nav-link text-primary-emphasis fw-medium <?= uri_string() === 'home/showUkm/' . $ukm['id_ukm'] ? 'active' : '' ?>" href="<?= uri_string() === 'home/showUkm/' . $ukm['id_ukm'] ? '#' : base_url('home/showUkm/' . $ukm['id_ukm']) ?>"><?= $ukm['nama_ukm'] ?></a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </li>

          <!-- <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'hasil_seleksi' ? 'active' : '' ?>" href="<?php echo base_url('hasil_seleksi') ?>"><i class="fas fa-trophy me-2" style="width: 2rem"></></i>Hasil Pendaftaran</a>
          </li> -->

          <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'prestasi' ? 'active' : '' ?>" href="<?php echo base_url('prestasi') ?>"><i class="fas fa-trophy me-2" style="width: 2rem"></></i>Prestasi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'dokumentasi' ? 'active' : '' ?>" href="<?php echo base_url('dokumentasi') ?>"><i class="fas fa-book me-2" style="width: 2rem"></></i>Dokumentasi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'progja' ? 'active' : '' ?>" href="<?php echo base_url('progja') ?>"><i class="fas fa-sitemap me-2" style="width: 2rem"></></i>Program Kerja</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'lpj' ? 'active' : '' ?>" href="<?php echo base_url('lpj') ?>"><i class="fas fa-file-invoice me-2" style="width: 2rem"></></i>LPJ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= uri_string() === 'anggota' ? 'active' : '' ?>" href="<?php echo base_url('anggota') ?>"><i class="fas fa-id-card me-2" style="width: 2rem"></></i>Anggota</a>
          </li>
          <?php if (!session('isLoggedIn')) : ?>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" href="#"><i class="fas fa-user me-2" style="width: 2rem"></></i>Masuk</a>
              <form action="<?= base_url('login') ?>" method="post" class="dropdown-menu p-4">
                <div class="d-flex justify-content-center align-items-center text-center" style="font-family: sans-serif; font-size: 12pt;">
                  Welcome to Unit Kegiatan Mahasiswa Universitas Negeri Manado
                </div>
                <div class="d-flex justify-content-center align-items-center mt-3">
                  <img src="<?= base_url('assets/css/unima_logo.png') ?>" class="w-25" />
                </div>
                <div class="form-floating mt-5 mb-3" style="font-family: sans-serif; font-size: 12pt;">
                  <input type="text" class="form-control" id="username" name="username" placeholder="name@example.com">
                  <label for="username">Username</label>
                </div>
                <div class="form-floating" style="font-family: sans-serif; font-size: 12pt;">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                  <label for="password">Password</label>
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberme">
                    <label class="form-check-label" for="rememberme">
                      Ingat Saya
                    </label>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary" style="font-size: 12pt;">Masuk</button>
              </form>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link <?= uri_string() === 'anggota' ? 'active' : '' ?>" href="<?php echo base_url('logout') ?>"><i class="fas fa-sign-out-alt" style="width: 2rem"></i>Keluar</a>
            </li>
          <?php endif; ?>
        </ul>

        <div class="dropdown">
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pendaftaran
          </a>

          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="pendaftaran_bpmk">Biro Pelayanan Mahasiswa Kristen (BPMK)</a></li>
            <li><a class="dropdown-item" href="pendaftaran_nnu">Nyong & Noni UNIMA (NNU)</a></li>
            <li><a class="dropdown-item" href="#">Coming Soon...</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

</body>