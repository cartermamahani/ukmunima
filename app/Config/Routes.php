<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');
$routes->post('login', 'HomeController::login');
$routes->get('logout', 'HomeController::logout');
$routes->get('home/showUkm/(:segment)', 'HomeController::showUkm/$1');
$routes->get('kelola_ukm/(:segment)', 'HomeController::kelola_ukm/$1');
$routes->get('prestasi', 'HomeController::prestasi');
$routes->get('kelola_prestasi/(:segment)', 'HomeController::kelola_prestasi/$1');
$routes->get('dokumentasi', 'HomeController::dokumentasi');
$routes->get('kelola_dokumentasi/(:segment)', 'HomeController::kelola_dokumentasi/$1');
$routes->get('progja', 'HomeController::progja');
$routes->get('kelola_progja/(:segment)', 'HomeController::kelola_progja/$1');
$routes->get('lpj', 'HomeController::lpj');
$routes->get('kelola_lpj/(:segment)', 'HomeController::kelola_lpj/$1');
$routes->get('anggota', 'HomeController::anggota');
$routes->get('kelola_anggota/(:segment)', 'HomeController::kelola_anggota/$1');
$routes->get('download/(:segment)', 'HomeController::download/$1');
$routes->get('dashboard', 'HomeController::dashboard');
$routes->post('kelola_prestasi/update_prestasi', 'HomeController::update_prestasi');
$routes->post('kelola_prestasi/delete_prestasi', 'HomeController::delete_prestasi');
$routes->post('kelola_prestasi/add_prestasi', 'HomeController::add_prestasi');
$routes->post('kelola_anggota/update_anggota', 'HomeController::update_anggota');
$routes->post('kelola_anggota/delete_anggota', 'HomeController::delete_anggota');
$routes->post('kelola_anggota/add_anggota', 'HomeController::add_anggota');
$routes->post('kelola_lpj/update_lpj', 'HomeController::update_lpj');
$routes->post('kelola_lpj/delete_lpj', 'HomeController::delete_lpj');
$routes->post('kelola_lpj/add_lpj', 'HomeController::add_lpj');
$routes->get('kelola_lpj/download/(:segment)', 'HomeController::download/$1');

$routes->post('kelola_progja/update_progja', 'HomeController::update_progja');
$routes->post('kelola_progja/delete_progja', 'HomeController::delete_progja');
$routes->post('kelola_progja/add_progja', 'HomeController::add_progja');
$routes->get('kelola_progja/download/(:segment)', 'HomeController::download/$1');

$routes->post('kelola_dokumentasi/update_dokumentasi', 'HomeController::update_dokumentasi');
$routes->post('kelola_dokumentasi/delete_dokumentasi', 'HomeController::delete_dokumentasi');
$routes->post('kelola_dokumentasi/add_dokumentasi', 'HomeController::add_dokumentasi');
$routes->get('kelola_dokumentasi/download/(:segment)', 'HomeController::download/$1');

$routes->post('kelola_ukm/update_ukm', 'HomeController::update_ukm');
$routes->post('kelola_ukm/delete_ukm', 'HomeController::delete_ukm');
$routes->post('kelola_ukm/add_ukm', 'HomeController::add_ukm');
$routes->get('kelola_ukm/download/(:segment)', 'HomeController::download/$1');

$routes->get('kelola_admin', 'HomeController::kelola_admin');
$routes->post('kelola_admin/update', 'HomeController::admin_update');
$routes->post('kelola_admin/add', 'HomeController::admin_add');
$routes->post('kelola_admin/delete', 'HomeController::admin_delete');

$routes->get('kegiatan/(:segment)', 'HomeController::kegiatan/$1');
$routes->get('kelola_kegiatan/(:segment)', 'HomeController::kelola_kegiatan/$1');
$routes->post('kelola_kegiatan/update_kegiatan', 'HomeController::update_kegiatan');
$routes->post('kelola_kegiatan/add_kegiatan', 'HomeController::add_kegiatan');
$routes->post('kelola_kegiatan/delete_kegiatan', 'HomeController::delete_kegiatan');

$routes->get('hasil_pemilihan', 'HomeController::hasil_pemilihan'); // Halaman pendaftaran
$routes->post('kelola_pendaftaran/proses', 'HomeController::proses'); // Proses pendaftaran

// File: app/Config/Routes.php

$routes->get('pendaftaran', 'HomeController::formPendaftaran');
$routes->post('pendaftaran/simpan', 'HomeController::simpanPendaftaran');
$routes->get('hasil_seleksi', 'HomeController::tampilHasilSeleksi');
$routes->get('hasil_seleksi', 'HomeController::hitungSkor');


$routes->get('pendaftaran_bpmk', 'HomeController::pendaftaran_bpmk');
$routes->post('daftar_bpmk', 'HomeController::daftar_bpmk');
$routes->get('hasil_daftar', 'HomeController::hasil_daftar');
$routes->get('kelola_pendaftaran_bpmk', 'HomeController::kelola_pendaftaran_bpmk');
$routes->post('kelola_pendaftaran_bpmk/tolak', 'HomeController::tolak_bpmk');
$routes->post('kelola_pendaftaran_bpmk/terima', 'HomeController::terima_bpmk');
$routes->post('kelola_pendaftaran_bpmk/delete_bpmk', 'HomeController::delete_bpmk');
$routes->get('kelola_pendaftaran_bpmk/download/(:segment)', 'HomeController::download/$1');

$routes->get('pendaftaran_nnu', 'HomeController::pendaftaran_nnu');
$routes->post('daftar_nnu', 'HomeController::daftar_nnu');
$routes->get('hasil_daftar', 'HomeController::hasil_daftar');
$routes->get('kelola_pendaftaran_nnu', 'HomeController::kelola_pendaftaran_nnu');
$routes->post('kelola_pendaftaran_nnu/tolak', 'HomeController::tolak_nnu');
$routes->post('kelola_pendaftaran_nnu/terima', 'HomeController::terima_nnu');
$routes->get('kelola_pendaftaran_nnu/download/(:segment)', 'HomeController::download/$1');





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
