<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\UkmModel;
use App\Models\PrestasiUkmModel;
use App\Models\DokumentasiModel;
use App\Models\ProgjaModel;
use App\Models\LpjModel;
use App\Models\AnggotaModel;
use App\Models\UserModel;
use App\Models\KegiatanModel;
use App\Models\DaftarBpmkModel;
use App\Models\DaftarNNUModel;
use App\Models\CalonPengurusBpmkModel;
use App\Helpers\EmailService;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class HomeController extends BaseController
{

    public function index()
    {
        $namaUkmModel = new UkmModel();
        $UkmModel = new KegiatanModel();
        $ukmNames = $namaUkmModel->findAll();
        $Data = $UkmModel->getKegiatanWithUkmName();
        return view('home', ['ukmNames' => $ukmNames, 'Data' => $Data]);
    }

    private function authenticateUser($username, $password)
    {
        $userModel = new UserModel();

        $user = $userModel->where('username', $username)->first();

        if ($user && md5($password) === $user['password']) {
            return [
                'authenticated' => true,
                'level_admin' => $user['level_admin'],
                'nama_admin' => $user['nama_admin'],
                'id_ukm' => $user['id_ukm']
            ];
        }

        return false;
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $result = $this->authenticateUser($username, $password);

            if ($result) {
                // Set the user's authentication status in the session
                session()->set('isLoggedIn', true);
                session()->set('userRole', $result['level_admin']);
                session()->set('user', $result['nama_admin']);
                session()->set('ukm', $result['id_ukm']);

                // Redirect the user to the dashboard after successful login
                return redirect()->route('dashboard');
            } else {
                session()->setFlashdata('status', 'error');
                return redirect()->to(base_url('/'));
            }
        }
    }

    public function logout()
    {
        // Destroy the session to log the user out
        // sesi untuk pengguna keluar
        session()->destroy();

        // Redirect the user to the login page or any other page you prefer
        // Arahkan pengguna ke halaman login atau halaman lain yang anda inginkan
        return redirect()->to(base_url('/'));
    }

    public function dashboard()
    {
        $namaUkmModel = new UkmModel();

        $ukmNames = $namaUkmModel->findAll();

        if (!session('isLoggedIn')) {
            return redirect()->to('#');
        }

        $nama_admin = session()->get('user');
        $ukm = session()->get('ukm');

        return view('dashboard', ['ukmNames' => $ukmNames, 'nama_admin' => $nama_admin, 'id_ukm' => $ukm]);
    }

    public function showUkm($ukmId)
    {
        $namaUkmModel = new UkmModel();

        $ukmData = $namaUkmModel->where('id_ukm', $ukmId)->first();
        $ukmNames = $namaUkmModel->findAll();
        return view('ukm', ['ukmData' => $ukmData, 'ukmNames' => $ukmNames]);
    }

    public function prestasi()
    {
        $prestasiUkmModel = new PrestasiUkmModel();
        $namaUkmModel = new UkmModel();

        $prestasiData = $prestasiUkmModel->findAll();
        $ukmNames = $namaUkmModel->findAll();

        usort($prestasiData, function ($a, $b) {
            return strcmp($a['nama_ukm'], $b['nama_ukm']);
        });

        return view('prestasi', ['prestasiData' => $prestasiData, 'ukmNames' => $ukmNames]);
    }

    public function dokumentasi()
    {
        $dokumentasiModel = new DokumentasiModel();
        $namaUkmModel = new UkmModel();

        $dokumentasiData = $dokumentasiModel->getDokumentasiWithUkmName();

        $ukmNames = $namaUkmModel->findAll();

        return view('dokumentasi', ['dokumentasiData' => $dokumentasiData, 'ukmNames' => $ukmNames]);
    }

    public function progja()
    {
        $progjaModel = new ProgjaModel();
        $ukmModel = new UkmModel();

        $progjaData = $progjaModel->getProgjaWithUkmName();

        $ukmNames = $ukmModel->findAll();

        return view('progja', ['progjaData' => $progjaData, 'ukmNames' => $ukmNames]);
    }

    public function lpj()
    {
        $lpjModel = new LpjModel();
        $ukmModel = new UkmModel();

        $lpjData = $lpjModel->getLpjWithUkmName();

        $ukmNames = $ukmModel->findAll();

        return view('lpj', ['lpjData' => $lpjData, 'ukmNames' => $ukmNames]);
    }

    public function anggota()
    {
        $anggotaModel = new AnggotaModel();
        $namaUkmModel = new UkmModel();

        $dataAnggota = $anggotaModel->getAnggota();
        $ukmNames = $namaUkmModel->findAll();

        return view('anggota', ['dataAnggota' => $dataAnggota, 'ukmNames' => $ukmNames]);
    }

    public function kelola_prestasi($ukmId)
    {
        $prestasiUkmModel = new PrestasiUkmModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }
        $ukm = session()->get('ukm');

        $namaUkm = $namaUkmModel
            ->select('nama_ukm')
            ->where('id_ukm', $ukmId)
            ->get()
            ->getRow('nama_ukm');
        if (session()->get('userRole') == 1) {
            $prestasiData = $prestasiUkmModel->findAll();
        } else {
            $prestasiData = $prestasiUkmModel->select('prestasi_ukm.*, nama_ukm.nama_ukm')
                ->join('nama_ukm', 'prestasi_ukm.nama_ukm = nama_ukm.nama_ukm')
                ->where('nama_ukm.id_ukm', $ukmId)
                ->findAll();
        }

        return view('kelola_prestasi', ['ukmNames' => $ukmNames, 'prestasiData' => $prestasiData, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function update_prestasi()
    {
        // Get the posted data from the AJAX request
        $id = $this->request->getPost('id');
        $namaPrestasi = $this->request->getPost('nama_prestasi');
        $tanggalPrestasi = $this->request->getPost('tanggal_prestasi');
        $id_ukm = session()->get('ukm');

        // Update the data in the database
        $prestasiModel = new PrestasiUkmModel();
        try {
            $prestasiModel->update($id, [
                'nama_prestasi' => $namaPrestasi,
                'tanggal_prestasi' => $tanggalPrestasi,
            ]);
            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_prestasi/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_prestasi/{$id_ukm}");
        }
    }

    public function delete_prestasi()
    {
        // Get the posted data from the AJAX request
        $id = $this->request->getPost('id');

        // Delete the data from the database
        $prestasiModel = new PrestasiUkmModel();
        $prestasiModel->delete($id);

        // Return a success response
        return $this->response->setJSON(['status' => 'success']);
    }

    public function add_prestasi()
    {
        $namaPrestasi = $this->request->getPost('nama_prestasi');
        $tanggalPrestasi = $this->request->getPost('tanggal_prestasi');
        $namaUkm = $this->request->getPost('nama_ukm');


        // Perform an insert query to add the data to the database
        $id_ukm = session()->get('ukm');
        $prestasiModel = new PrestasiUkmModel();
        $nama_ukmAdmin =  $this->request->getPost('nama_ukmAdmin');
        try {
            if (session()->get('userRole') == 1) {
                $prestasiModel->insert([
                    'nama_prestasi' => $namaPrestasi,
                    'tanggal_prestasi' => $tanggalPrestasi,
                    'nama_ukm' => $nama_ukmAdmin,
                ]);
            } else {
                $prestasiModel->insert([
                    'nama_prestasi' => $namaPrestasi,
                    'tanggal_prestasi' => $tanggalPrestasi,
                    'nama_ukm' => $namaUkm,
                ]);
            }
            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_prestasi/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_prestasi/{$id_ukm}");
        }
    }

    public function kelola_anggota($ukmId)
    {
        $UkmModel = new AnggotaModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }
        $ukm = session()->get('ukm');

        $namaUkm = $namaUkmModel
            ->select('nama_ukm')
            ->where('id_ukm', $ukmId)
            ->get()
            ->getRow('nama_ukm');
        if (session()->get('userRole') == 1) {
            $Data = $UkmModel->getAnggota();
        } else {
            $Data = $UkmModel->select('anggota.*, nama_ukm.nama_ukm') // Select columns from anggota and nama_ukm tables
                ->join('nama_ukm', 'anggota.id_ukm = nama_ukm.id_ukm') // Join with nama_ukm table using id_ukm
                ->where('anggota.id_ukm', $ukmId)
                ->orderBy('nama_ukm.nama_ukm', 'ASC') // Condition to match id_ukm
                ->findAll();
        }

        return view('kelola_anggota', ['ukmNames' => $ukmNames, 'prestasiData' => $Data, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function update_anggota()
    {
        // Get the posted data from the AJAX request
        $id = $this->request->getPost('id');
        $nim = $this->request->getPost('nim');
        $nama_mahasiswa = $this->request->getPost('nama_mahasiswa');
        $fakultas = $this->request->getPost('fakultas');
        $jurusan = $this->request->getPost('jurusan');
        $alamat = $this->request->getPost('alamat');
        $tempat_lahir = $this->request->getPost('tempat_lahir');
        $tanggal_lahir = $this->request->getPost('tanggal_lahir');
        $id_ukm = session()->get('ukm');

        // Update the data in the database
        $Model = new AnggotaModel();
        try {
            $Model->update($id, [
                'nim' => $nim,
                'nama_mahasiswa' => $nama_mahasiswa,
                'fakultas' => $fakultas,
                'jurusan' => $jurusan,
                'alamat' => $alamat,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir,
            ]);

            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_anggota/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_anggota/{$id_ukm}");
        }
    }

    public function delete_anggota()
    {
        // Get the posted data from the AJAX request
        $id = $this->request->getPost('id');

        // Delete the data from the database
        $Model = new AnggotaModel();
        $Model->delete($id);

        // Return a success response
        return $this->response->setJSON(['status' => 'success']);
    }

    public function add_anggota()
    {
        $nim = $this->request->getPost('nim');
        $nama_mahasiswa = $this->request->getPost('nama_mahasiswa');
        $fakultas = $this->request->getPost('fakultas');
        $jurusan = $this->request->getPost('jurusan');
        $alamat = $this->request->getPost('alamat');
        $tempat_lahir = $this->request->getPost('tempat_lahir');
        $tanggal_lahir = $this->request->getPost('tanggal_lahir');
        $id_ukm = $this->request->getPost('idUkm');
        $id_ukmAdmin =  $this->request->getPost('id_ukm');

        // Perform an insert query to add the data to the database
        $Model = new AnggotaModel();

        try {
            if (session()->get('userRole') == 1) {
                $Model->insert([
                    'nim' => $nim,
                    'nama_mahasiswa' => $nama_mahasiswa,
                    'fakultas' => $fakultas,
                    'jurusan' => $jurusan,
                    'alamat' => $alamat,
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $tanggal_lahir,
                    'id_ukm' => $id_ukmAdmin,
                ]);
            } else {
                $Model->insert([
                    'nim' => $nim,
                    'nama_mahasiswa' => $nama_mahasiswa,
                    'fakultas' => $fakultas,
                    'jurusan' => $jurusan,
                    'alamat' => $alamat,
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $tanggal_lahir,
                    'id_ukm' => $id_ukm,
                ]);
            }

            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_anggota/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_anggota/{$id_ukm}");
        }
    }

    // Helper function to generate a unique filename
    private function getUniqueFilename($directory, $filename)
    {
        $counter = 1;
        $newFilename = $filename;

        while (file_exists($directory . '/' . $newFilename)) {
            $newFilename = pathinfo($filename, PATHINFO_FILENAME) . '_' . $counter . '.' . pathinfo($filename, PATHINFO_EXTENSION);
            $counter++;
        }

        return $newFilename;
    }

    public function kelola_lpj($ukmId)
    {
        $UkmModel = new LpjModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }
        $ukm = session()->get('ukm');

        $namaUkm = $namaUkmModel
            ->select('nama_ukm')
            ->where('id_ukm', $ukmId)
            ->get()
            ->getRow('nama_ukm');
        if (session()->get('userRole') == 1) {
            $Data = $UkmModel->getLpjWithUkmName();
        } else {
            $Data = $UkmModel->select('lpj.*, nama_ukm.nama_ukm') // Select columns from anggota and nama_ukm tables
                ->join('nama_ukm', 'lpj.id_ukm = nama_ukm.id_ukm') // Join with nama_ukm table using id_ukm
                ->where('lpj.id_ukm', $ukmId)
                ->orderBy('nama_ukm.nama_ukm', 'ASC') // Condition to match id_ukm
                ->findAll();
        }

        return view('kelola_lpj', ['ukmNames' => $ukmNames, 'Data' => $Data, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function add_lpj()
    {
        helper(['form', 'url']);

        $Model = new LpjModel();

        $file = $this->request->getFile('file');
        $originalName = $file->getName(); // Get the original filename
        $newName = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalName);
        $file->move(ROOTPATH . 'assets/doc', $newName);

        $id_ukm = $this->request->getPost('idUkm');
        $nama_bidang = $this->request->getPost('nama_bidang');
        $judul = $this->request->getPost('judul');
        $tanggal_periode_lpj = $this->request->getPost('tanggal_periode_lpj');
        $keterangan = $this->request->getPost('keterangan');
        $id_ukmAdmin =  $this->request->getPost('id_ukm');

        try {
            if (session()->get('userRole') == 1) {
                $Model->insert([
                    'id_ukm' => $id_ukmAdmin,
                    'nama_bidang' => $nama_bidang,
                    'judul' => $judul,
                    'tanggal_periode_lpj' => $tanggal_periode_lpj,
                    'keterangan' => $keterangan,
                    'file_name' => $newName
                ]);
            } else {
                $Model->insert([
                    'id_ukm' => $id_ukm,
                    'nama_bidang' => $nama_bidang,
                    'judul' => $judul,
                    'tanggal_periode_lpj' => $tanggal_periode_lpj,
                    'keterangan' => $keterangan,
                    'file_name' => $newName
                ]);
            }

            $ukm = session()->get('ukm');

            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_lpj/{$ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_lpj/{$ukm}");
        }
    }

    // HomeController.php
    public function update_lpj()
    {
        helper(['form', 'url']);

        $Model = new LpjModel();

        $ukm = session()->get('ukm');
        $id_lpj = $this->request->getPost('id_lpj');
        $id_ukm = $this->request->getPost('idUkm');
        $nama_bidang = $this->request->getPost('nama_bidang');
        $judul = $this->request->getPost('judul');
        $tanggal_periode_lpj = $this->request->getPost('tanggal_periode_lpj');
        $keterangan = $this->request->getPost('keterangan');
        $currentFile = $this->request->getPost('current_file');
        $newFile = $this->request->getFile('new_file');
        $data = [];

        if ($newFile->isValid() && !$newFile->hasMoved()) {
            if (!empty($currentFile)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFile;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            // Get the original filename
            $originalName = $newFile->getName();
            $newName = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalName);
            $newFile->move(ROOTPATH . 'assets/doc', $newName);
            $data = [
                'id_ukm' => $id_ukm,
                'nama_bidang' => $nama_bidang,
                'judul' => $judul,
                'tanggal_periode_lpj' => $tanggal_periode_lpj,
                'keterangan' => $keterangan,
                'file_name' => $newName
            ];
        } else {
            $data = [
                'id_ukm' => $id_ukm,
                'nama_bidang' => $nama_bidang,
                'judul' => $judul,
                'tanggal_periode_lpj' => $tanggal_periode_lpj,
                'keterangan' => $keterangan,
                'file_name' => $currentFile
            ];
        }

        try {
            $Model->update($id_lpj, $data);

            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_lpj/{$ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_lpj/{$ukm}");
        }
    }

    public function delete_lpj()
    {
        $id = $this->request->getPost('id_lpj');
        $id_ukm = $this->request->getPost('idUkm');
        $currentFile = $this->request->getPost('current_file');
        try {
            $Model = new LpjModel();
            $Model->delete($id);
            session()->setFlashdata('status', 'success');
            if (!empty($currentFile)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFile;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            return redirect()->to("/kelola_lpj/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_lpj/{$id_ukm}");
        }
    }

    public function download($fileName)
    {

        $file = ROOTPATH . 'assets/doc/' . $fileName;

        if (!file_exists($file)) {
            session()->setFlashdata('status', 'dlerror');
            exit();
        }

        // Set appropriate headers to force download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));

        // Read the file and output its contents
        readfile($file);
    }

    public function kelola_progja($ukmId)
    {
        $UkmModel = new ProgjaModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }
        $ukm = session()->get('ukm');

        $namaUkm = $namaUkmModel
            ->select('nama_ukm')
            ->where('id_ukm', $ukmId)
            ->get()
            ->getRow('nama_ukm');
        if (session()->get('userRole') == 1) {
            $Data = $UkmModel->getProgjaWithUkmName();
        } else {
            $Data = $UkmModel->select('progja.*, nama_ukm.nama_ukm') // Select columns from anggota and nama_ukm tables
                ->join('nama_ukm', 'progja.id_ukm = nama_ukm.id_ukm') // Join with nama_ukm table using id_ukm
                ->where('progja.id_ukm', $ukmId)
                ->orderBy('nama_ukm.nama_ukm', 'ASC') // Condition to match id_ukm
                ->findAll();
        }

        return view('kelola_progja', ['ukmNames' => $ukmNames, 'Data' => $Data, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function add_progja()
    {
        helper(['form', 'url']);

        $Model = new ProgjaModel();

        $file = $this->request->getFile('file');
        $originalName = $file->getName(); // Get the original filename
        $newName = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalName);
        $file->move(ROOTPATH . 'assets/doc', $newName);

        $id_ukm = $this->request->getPost('idUkm');
        $id_ukmAdmin =  $this->request->getPost('id_ukm');
        $nama_bidang = $this->request->getPost('nama_bidang');
        $judul = $this->request->getPost('nama_progja');
        $tanggal_progja = $this->request->getPost('tanggal_progja');
        $keterangan = $this->request->getPost('keterangan');

        try {
            if (session()->get('userRole') == 1) {
                $Model->insert([
                    'id_ukm' => $id_ukmAdmin,
                    'nama_bidang' => $nama_bidang,
                    'nama_progja' => $judul,
                    'tanggal_progja' => $tanggal_progja,
                    'keterangan' => $keterangan,
                    'file_name' => $newName
                ]);
            } else {
                $Model->insert([
                    'id_ukm' => $id_ukm,
                    'nama_bidang' => $nama_bidang,
                    'nama_progja' => $judul,
                    'tanggal_progja' => $tanggal_progja,
                    'keterangan' => $keterangan,
                    'file_name' => $newName
                ]);
            }

            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_progja/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_progja/{$id_ukm}");
        }
    }

    // HomeController.php
    public function update_progja()
    {
        helper(['form', 'url']);

        $Model = new ProgjaModel();

        $id_progja = $this->request->getPost('id_progja');
        $id_ukm = $this->request->getPost('idUkm');
        $nama_bidang = $this->request->getPost('nama_bidang');
        $nama_progja = $this->request->getPost('nama_progja');
        $tanggal_progja = $this->request->getPost('tanggal_progja');
        $keterangan = $this->request->getPost('keterangan');
        $currentFile = $this->request->getPost('current_file');
        $newFile = $this->request->getFile('new_file');
        $data = [];

        if ($newFile->isValid() && !$newFile->hasMoved()) {
            if (!empty($currentFile)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFile;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            // Get the original filename
            $originalName = $newFile->getName();
            $newName = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalName);
            $newFile->move(ROOTPATH . 'assets/doc', $newName);
            $data = [
                'nama_bidang' => $nama_bidang,
                'nama_progja' => $nama_progja,
                'tanggal_progja' => $tanggal_progja,
                'keterangan' => $keterangan,
                'file_name' => $newName
            ];
        } else {
            $data = [
                'nama_bidang' => $nama_bidang,
                'nama_progja' => $nama_progja,
                'tanggal_progja' => $tanggal_progja,
                'keterangan' => $keterangan,
                'file_name' => $currentFile
            ];
        }

        try {
            $Model->update($id_progja, $data);

            $UkmModel = new ProgjaModel();
            $namaUkmModel = new UkmModel();
            $ukmNames = $namaUkmModel->findAll();

            $ukm = session()->get('ukm');

            $namaUkm = $namaUkmModel
                ->select('nama_ukm')
                ->where('id_ukm', session()->get('ukm_id'))
                ->get()
                ->getRow('nama_ukm');
            $Data = $UkmModel->select('progja.*, nama_ukm.nama_ukm') // Select columns from anggota and nama_ukm tables
                ->join('nama_ukm', 'progja.id_ukm = nama_ukm.id_ukm') // Join with nama_ukm table using id_ukm
                ->where('progja.id_ukm', session()->get('ukm_id')) // Condition to match id_ukm
                ->findAll();
            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_progja/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_progja/{$id_ukm}");
        }
    }

    public function delete_progja()
    {
        $id = $this->request->getPost('id_progja');
        $id_ukm = $this->request->getPost('idUkm');
        $currentFile = $this->request->getPost('current_file');
        try {
            $Model = new ProgjaModel();
            $Model->delete($id);
            session()->setFlashdata('status', 'success');
            if (!empty($currentFile)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFile;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            return redirect()->to("/kelola_progja/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_progja/{$id_ukm}");
        }
    }

    public function kelola_dokumentasi($ukmId)
    {
        $UkmModel = new DokumentasiModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }

        $ukm = session()->get('ukm');

        $namaUkm = $namaUkmModel
            ->select('nama_ukm')
            ->where('id_ukm', $ukmId)
            ->get()
            ->getRow('nama_ukm');

        if (session()->get('userRole') == 1) {
            $Data = $UkmModel->getDokumentasiWithUkmName();
        } else {
            $Data = $UkmModel->select('dokumentasi.*, nama_ukm.nama_ukm') // Select columns from anggota and nama_ukm tables
                ->join('nama_ukm', 'dokumentasi.id_ukm = nama_ukm.id_ukm') // Join with nama_ukm table using id_ukm
                ->where('dokumentasi.id_ukm', $ukmId)
                ->orderBy('nama_ukm.nama_ukm', 'ASC') // Condition to match id_ukm
                ->findAll();
        }

        return view('kelola_dokumentasi', ['ukmNames' => $ukmNames, 'Data' => $Data, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function add_dokumentasi()
    {
        helper(['form', 'url']);

        $Model = new DokumentasiModel();

        $file = $this->request->getFile('file');
        $originalName = $file->getName(); // Get the original filename
        $newName = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalName);
        $file->move(ROOTPATH . 'assets/doc', $newName);

        $id_ukm = $this->request->getPost('idUkm');
        $id_ukmAdmin =  $this->request->getPost('id_ukm');

        $tanggal_dokumentasi = $this->request->getPost('tanggal_dokumentasi');
        $keterangan = $this->request->getPost('keterangan');

        try {
            if (session()->get('userRole') == 1) {
                $Model->insert([
                    'id_ukm' => $id_ukmAdmin,
                    'tanggal_dokumentasi' => $tanggal_dokumentasi,
                    'file_name' => $newName,
                    'keterangan' => $keterangan
                ]);
            } else {
                $Model->insert([
                    'id_ukm' => $id_ukm,
                    'tanggal_dokumentasi' => $tanggal_dokumentasi,
                    'file_name' => $newName,
                    'keterangan' => $keterangan
                ]);
            }
            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_dokumentasi/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_dokumentasi/{$id_ukm}");
        }
    }

    public function update_dokumentasi()
    {
        helper(['form', 'url']);

        $Model = new DokumentasiModel();

        $id_ukm = session()->get('ukm');
        $id_dokumentasi = $this->request->getPost('id_dokumentasi');
        $tanggal_dokumentasi = $this->request->getPost('tanggal_dokumentasi');
        $keterangan = $this->request->getPost('keterangan');
        $currentFile = $this->request->getPost('current_file');
        $newFile = $this->request->getFile('new_file');
        $data = [];

        if ($newFile->isValid() && !$newFile->hasMoved()) {
            if (!empty($currentFile)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFile;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            // Get the original filename
            $originalName = $newFile->getName();
            $newName = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalName);
            $newFile->move(ROOTPATH . 'assets/doc', $newName);
            $data = [
                'tanggal_dokumentasi' => $tanggal_dokumentasi,
                'keterangan' => $keterangan,
                'file_name' => $newName
            ];
        } else {
            $data = [
                'tanggal_dokumentasi' => $tanggal_dokumentasi,
                'keterangan' => $keterangan,
                'file_name' => $currentFile
            ];
        }

        try {
            $Model->update($id_dokumentasi, $data);

            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_dokumentasi/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_dokumentasi/{$id_ukm}");
        }
    }

    public function delete_dokumentasi()
    {
        $id = $this->request->getPost('id_dokumentasi');
        $id_ukm = $this->request->getPost('idUkm');
        $currentFile = $this->request->getPost('current_file');
        try {
            $Model = new DokumentasiModel();
            $Model->delete($id);
            session()->setFlashdata('status', 'success');
            if (!empty($currentFile)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFile;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            return redirect()->to("/kelola_dokumentasi/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_dokumentasi/{$id_ukm}");
        }
    }

    public function kelola_ukm($ukmId)
    {
        $UkmModel = new UkmModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }
        $ukm = session()->get('ukm');

        $namaUkm = $namaUkmModel
            ->select('nama_ukm')
            ->where('id_ukm', $ukmId)
            ->get()
            ->getRow('nama_ukm');

        if (session()->get('userRole') == 1) {
            $Data = $UkmModel->findAll();
        } else {
            $Data = $UkmModel->where(['id_ukm' => $ukmId])->findAll();
        }

        return view('kelola_ukm', ['ukmNames' => $ukmNames, 'Data' => $Data, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function add_ukm()
    {
        helper(['form', 'url']);

        $Model = new UkmModel();

        $file = $this->request->getFile('logo_ukm');
        $originalName = $file->getName(); // Get the original filename
        $newName = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalName);
        $file->move(ROOTPATH . 'assets/doc', $newName);

        $file_struktur = $this->request->getFile('foto_struktur');
        $originalNameStruktur = $file_struktur->getName(); // Get the original filename
        $newNameStruktur = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalNameStruktur);
        $file_struktur->move(ROOTPATH . 'assets/doc', $newNameStruktur);

        $id_ukm = $this->request->getPost('idUkm');
        $nama_ukm = $this->request->getPost('nama_ukm');
        $keterangan = $this->request->getPost('keterangan');
        $visi = $this->request->getPost('visi');
        $misi = $this->request->getPost('misi');
        $email = $this->request->getPost('email');
        $nomor_hp = $this->request->getPost('nomor_hp');

        try {
            $Model->insert([
                'nama_ukm' => $nama_ukm,
                'logo_ukm' => $newName,
                'keterangan_ukm' => $keterangan,
                'visi' => $visi,
                'misi' => $misi,
                'email' => $email,
                'nomor_hp' => $nomor_hp,
                'foto_struktur' => $newNameStruktur,
            ]);

            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_ukm/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_ukm/{$id_ukm}");
        }
    }

    public function update_ukm()
    {
        helper(['form', 'url']);

        $Model = new UkmModel();

        $id_ukm = $this->request->getPost('id_ukm');
        $nama_ukm = $this->request->getPost('nama_ukm');
        $keterangan = $this->request->getPost('keterangan');
        $visi = $this->request->getPost('visi');
        $misi = $this->request->getPost('misi');
        $email = $this->request->getPost('email');
        $nomor_hp = $this->request->getPost('nomor_hp');
        $current_fileStruktur = $this->request->getPost('current_fileStruktur');
        $current_fileLogo = $this->request->getPost('current_fileLogo');
        $new_fileLogo = $this->request->getFile('new_fileLogo');
        $new_fileStruktur = $this->request->getFile('new_fileStruktur');
        $data = [];

        if (($new_fileLogo->isValid() && !$new_fileLogo->hasMoved()) || ($new_fileStruktur->isValid() && !$new_fileStruktur->hasMoved())) {
            if ($new_fileLogo->isValid() && !empty($current_fileLogo)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $current_fileLogo;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            if ($new_fileStruktur->isValid() && !empty($current_fileStruktur)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $current_fileStruktur;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            $logoToUpload = $current_fileLogo;
            $strukturToUpload = $current_fileStruktur;
            // Get the original filename
            if ($new_fileLogo->isValid()) {
                $originalNameLogo = $new_fileLogo->getName();
                $newNameLogo = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalNameLogo);
                $new_fileLogo->move(ROOTPATH . 'assets/doc', $newNameLogo);
                $logoToUpload = $newNameLogo;
            }
            if ($new_fileStruktur->isValid()) {
                $originalNameStruktur = $new_fileStruktur->getName();
                $newNameStruktur = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalNameStruktur);
                $new_fileStruktur->move(ROOTPATH . 'assets/doc', $newNameStruktur);
                $strukturToUpload = $newNameStruktur;
            }

            $data = [
                'nama_ukm' => $nama_ukm,
                'logo_ukm' => $logoToUpload,
                'keterangan_ukm' => $keterangan,
                'visi' => $visi,
                'misi' => $misi,
                'email' => $email,
                'nomor_hp' => $nomor_hp,
                'foto_struktur' => $strukturToUpload,
            ];
        } else {
            $data = [
                'nama_ukm' => $nama_ukm,
                'keterangan_ukm' => $keterangan,
                'visi' => $visi,
                'misi' => $misi,
                'email' => $email,
                'nomor_hp' => $nomor_hp,
            ];
        }

        try {
            $Model->update($id_ukm, $data);

            session()->setFlashdata('status', 'success');
            $ukmID = session()->get('userRole') == 1 ? 0 : $id_ukm;
            return redirect()->to("/kelola_ukm/{$ukmID}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            $ukmID = session()->get('userRole') == 1 ? 0 : $id_ukm;
            return redirect()->to("/kelola_ukm/{$ukmID}");
        }
    }

    public function delete_ukm()
    {
        $id = $this->request->getPost('id_ukm');
        $currentFileLogo = $this->request->getPost('current_fileLogo');
        $currentFileStruktur = $this->request->getPost('current_fileStruktur');
        try {
            $Model = new UkmModel();
            $Model->delete($id);
            session()->setFlashdata('status', 'success');
            if (!empty($currentFileLogo)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFileLogo;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            if (!empty($currentFileStruktur)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFileStruktur;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            $ukmID = session()->get('userRole') == 1 ? 0 : $id;
            return redirect()->to("/kelola_ukm/{$ukmID}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            $ukmID = session()->get('userRole') == 1 ? 0 : $id;
            return redirect()->to("/kelola_ukm/{$ukmID}");
        }
    }

    public function kelola_admin()
    {
        $UkmModel = new LoginModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn') || !session()->get('userRole') == 1) {
            return redirect()->to(base_url('/'));
        }
        $ukm = session()->get('ukm');

        $Data = $UkmModel->select('id_admin, login.id_ukm, nama_ukm, nama_admin, username, password, level_admin')
            ->join('nama_ukm', 'login.id_ukm = nama_ukm.id_ukm')
            ->get()
            ->getResultArray();
        $namaUkm = "Kelola Admin";

        return view('kelola_admin', ['ukmNames' => $ukmNames, 'Data' => $Data, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function admin_update()
    {
        $idAdmin = $this->request->getPost('id_admin');

        $newData = [
            'nama_admin' => $this->request->getPost('nama_admin'),
            'username' => $this->request->getPost('username'),
            'level_admin' => $this->request->getPost('level_admin')
        ];

        $idUkm = trim($this->request->getPost('id_ukm'));
        $currentid_ukm = trim($this->request->getPost('currentid_ukm'));
        if (is_numeric($idUkm)) {
            if ($idUkm != $currentid_ukm) {
                $newData['id_ukm'] = $idUkm;
            }
        }

        $password = $this->request->getPost('password');
        $currentPassword = $this->request->getPost('currentPassword');
        if (!empty($password) && ($password != $currentPassword)) {
            // Hash the new password using MD5
            $hashedPassword = md5($password);
            $newData['password'] = $hashedPassword;
        }

        try {
            // Update the database with the new data
            $UkmModel = new LoginModel();
            $UkmModel->update($idAdmin, $newData);

            session()->setFlashdata('status', 'success');
            return redirect()->to(base_url('kelola_admin'));
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to(base_url('kelola_admin'));
        }
    }

    public function admin_add()
    {
        $newData = [
            'id_ukm' => $this->request->getPost('id_ukm'),
            'nama_admin' => $this->request->getPost('nama_admin'),
            'username' => $this->request->getPost('username'),
            'level_admin' => $this->request->getPost('level_admin')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            // Hash the new password using MD5
            $hashedPassword = md5($password);
            $newData['password'] = $hashedPassword;
        }

        try {
            // Update the database with the new data
            $UkmModel = new LoginModel();
            $UkmModel->insert($newData);

            session()->setFlashdata('status', 'success');
            return redirect()->to(base_url('kelola_admin'));
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to(base_url('kelola_admin'));
        }
    }

    public function admin_delete()
    {
        $id = $this->request->getPost('id_admin');
        try {
            $Model = new LoginModel();
            $Model->delete($id);
            session()->setFlashdata('status', 'success');
            return redirect()->to(base_url('kelola_admin'));
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to(base_url('kelola_admin'));
        }
    }

    public function kelola_kegiatan($ukmId)
    {
        $UkmModel = new KegiatanModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }

        $ukm = session()->get('ukm');

        $namaUkm = $namaUkmModel
            ->select('nama_ukm')
            ->where('id_ukm', $ukmId)
            ->get()
            ->getRow('nama_ukm');

        if (session()->get('userRole') == 1) {
            $Data = $UkmModel->getKegiatanWithUkmName();
        } else {
            $Data = $UkmModel->select('kegiatan.*, nama_ukm.nama_ukm') // Select columns from anggota and nama_ukm tables
                ->join('nama_ukm', 'kegiatan.id_ukm = nama_ukm.id_ukm') // Join with nama_ukm table using id_ukm
                ->where('kegiatan.id_ukm', $ukmId)
                ->orderBy('nama_ukm.nama_ukm', 'ASC') // Condition to match id_ukm
                ->findAll();
        }

        return view('kelola_kegiatan', ['ukmNames' => $ukmNames, 'Data' => $Data, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function add_kegiatan()
    {
        helper(['form', 'url']);

        $Model = new KegiatanModel();

        $file = $this->request->getFile('file');
        $originalName = $file->getName(); // Get the original filename
        $newName = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalName);
        $file->move(ROOTPATH . 'assets/doc', $newName);

        $id_ukm = $this->request->getPost('idUkm');
        $id_ukmAdmin =  $this->request->getPost('id_ukm');

        $waktu = $this->request->getPost('waktu');
        $judul = $this->request->getPost('judul');
        $keterangan = $this->request->getPost('keterangan');

        try {
            if (session()->get('userRole') == 1) {
                $Model->insert([
                    'id_ukm' => $id_ukmAdmin,
                    'waktu' => $waktu,
                    'judul' => $judul,
                    'file_name' => $newName,
                    'keterangan' => $keterangan
                ]);
            } else {
                $Model->insert([
                    'id_ukm' => $id_ukm,
                    'waktu' => $waktu,
                    'judul' => $judul,
                    'file_name' => $newName,
                    'keterangan' => $keterangan
                ]);
            }
            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_kegiatan/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_kegiatan/{$id_ukm}");
        }
    }

    public function update_kegiatan()
    {
        helper(['form', 'url']);

        $Model = new KegiatanModel();

        $id_ukm = session()->get('ukm');
        $id = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');
        $waktu = $this->request->getPost('waktu');
        $keterangan = $this->request->getPost('keterangan');
        $currentFile = $this->request->getPost('current_file');
        $newFile = $this->request->getFile('new_file');
        $data = [];

        if ($newFile->isValid() && !$newFile->hasMoved()) {
            if (!empty($currentFile)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFile;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            // Get the original filename
            $originalName = $newFile->getName();
            $newName = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalName);
            $newFile->move(ROOTPATH . 'assets/doc', $newName);
            $data = [
                'judul' => $judul,
                'waktu' => $waktu,
                'keterangan' => $keterangan,
                'file_name' => $newName
            ];
        } else {
            $data = [
                'judul' => $judul,
                'waktu' => $waktu,
                'keterangan' => $keterangan,
                'file_name' => $currentFile
            ];
        }

        try {
            $Model->update($id, $data);

            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_kegiatan/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_kegiatan/{$id_ukm}");
        }
    }

    public function delete_kegiatan()
    {
        $id = $this->request->getPost('id');
        $id_ukm = $this->request->getPost('idUkm');
        $currentFile = $this->request->getPost('current_file');
        try {
            $Model = new KegiatanModel();
            $Model->delete($id);
            session()->setFlashdata('status', 'success');
            if (!empty($currentFile)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFile;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            return redirect()->to("/kelola_kegiatan/{$id_ukm}");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_kegiatan/{$id_ukm}");
        }
    }

    public function kegiatan($id)
    {
        $namaUkmModel = new KegiatanModel();

        $ukmData = $namaUkmModel->where('id', $id)->first();
        $ukmNames = $namaUkmModel->findAll();
        return view('kegiatan', ['ukmData' => $ukmData, 'ukmNames' => $ukmNames]);
    }

    public function daftar_bpmk()
    {
        helper(['form', 'url']);

        $Model = new DaftarBpmkModel();

        if ($this->request->getFile('sbm')->isValid()) {
            $fileSbm = $this->request->getFile('sbm');
            $originalNameSbm = $fileSbm ? $fileSbm->getName() : null; // Get the original filename
            $newNameSbm = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalNameSbm);
            $fileSbm->move(ROOTPATH . 'assets/doc', $newNameSbm);
        }

        if ($this->request->getFile('krs')->isValid()) {
            $fileKrs = $this->request->getFile('krs');
            $originalNameKrs = $fileKrs ? $fileKrs->getName() : null; // Get the original filename
            $newNameKrs = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalNameKrs);
            $fileKrs->move(ROOTPATH . 'assets/doc', $newNameKrs);
        }

        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $cekaktiv_pelayanan = $this->request->getPost('aktiv_pelayanan');
        $cekpdp = $this->request->getPost('pdp');
        $cekorganisasi = $this->request->getPost('organisasi');
        $cekmuridkan = $this->request->getPost('muridkan');

        $aktiv_pelayanan = $cekaktiv_pelayanan === "on" ? 1 : 0;
        $pdp = $cekpdp === "on" ? 1 : 0;
        $organisasi = $cekorganisasi === "on" ? 1 : 0;
        $muridkan = $cekmuridkan === "on" ? 1 : 0;

        $skor = 0;  //ini dp skor awal, 0
        $skor += $aktiv_pelayanan != 0 ? 20 : 0;  //kalo pendaftar da centang aktif pelayanan, dp skor ta tambah 20 poin
        $skor += $pdp != 0 ? 15 : 0;  //kalo pendaftar da centang pdp, dp skor ta tambah 15 poin
        $skor += $newNameSbm != null ? 10 : 0; //kalo pendaftar da upload sbm, dp skor ta tambah 10 poin
        $skor += $organisasi != 0 ? 15 : 0;    //kalo pendaftar da centang organisasi, dp skor ta tambah 15 poin
        $skor += $muridkan != 0 ? 20 : 0;      //kalo pendaftar da centang muridkan, dp skor ta tambah 20 poin
        $skor += $newNameKrs != null ? 20 : 0; //kalo pendaftar da upload KRS, dp skor ta tambah 20 poin

        //total kalo isi samua, 100 poin

        try {
            $Model->insert([
                'email' => $email,
                'nama' => $nama,
                'aktiv_pelayanan' => $aktiv_pelayanan,
                'pdp' => $pdp,
                'sbm' => $newNameSbm,
                'organisasi' => $organisasi,
                'muridkan' => $muridkan,
                'aktiv_kuliah' => $newNameKrs,
                'skor' => $skor,
            ]);
            session()->setFlashdata('status', 'success');
            return redirect()->to("/hasil_daftar");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/hasil_daftar");
        }
    }

    public function hasil_daftar()
    {
        $namaUkmModel = new UkmModel();

        $ukmNames = $namaUkmModel->findAll();

        return view('hasil_daftar', ['ukmNames' => $ukmNames]);
    }

    public function pendaftaran_bpmk()
    {
        $namaUkmModel = new UkmModel();

        $ukmNames = $namaUkmModel->findAll();

        return view('formulir_BPMK', ['ukmNames' => $ukmNames]);
    }

    public function kelola_pendaftaran_bpmk()
    {
        $UkmModel = new DaftarBpmkModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }

        $ukm = session()->get('ukm');

        $namaUkm = $namaUkmModel
            ->select('nama_ukm')
            ->where('id_ukm', 1)
            ->get()
            ->getRow('nama_ukm');

        if (session()->get('userRole') == 1) {
            $Data = $UkmModel->getKegiatanWithUkmName();
        } else {
            $Data = $UkmModel->getAll();
        }

        return view('kelola_pendaftaran_bpmk', ['ukmNames' => $ukmNames, 'Data' => $Data, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function sendmail($namefrom, $to, $nameto, $subject, $acc)
    {
        $from  = "nandesvicky@gmail.com";

        if ($acc == true) {
            $message = '<h3>Halo, ' . $nameto . '</h3> <br/><p>Kami dengan senang hati mengumumkan bahwa Anda telah diterima sebagai calon pengurus ' . $namefrom . '.
            <br/>Keputusan ini diambil setelah mempertimbangkan dengan cermat pengalaman, kualifikasi, dan komitmen Anda terhadap organisasi kami.
            <br/>Kami berharap Anda akan membawa kontribusi berharga dalam pengembangan dan pertumbuhan unit kegiatan mahasiswa kami.
            <br/>Selamat dan selamat bergabung!
            <br/><br/>Nantikan info selanjutnya.
            <br/><b>Mohon simpan serta cetak pesan ini sebagai bukti untuk dijadikan berkas registrasi kembali.</b></p>';
        } else {
            $message = '<h3>Halo, ' . $nameto . '</h3> <br/><p>"Kami dengan sangat menyesal memberitahukan bahwa setelah pertimbangan yang matang,
            <br/>kami harus menolak pengajuan Anda untuk menjadi calon pengurus ' . $namefrom . '. Keputusan ini diambil setelah mempertimbangkan berbagai faktor dan kebutuhan organisasi kami saat ini.
            <br/>Kami berterima kasih atas partisipasi Anda dalam proses seleksi ini dan menghargai minat Anda untuk bergabung dengan kami."</p>';
        }


        try {
            $email = service('email');

            $email->setFrom($from, $namefrom);
            $email->setTo($to);

            $email->setSubject($subject);
            $email->setMessage($message);

            if ($email->send()) {
                return true;
            } else {
                print_r(false);
                return false;
            }
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public function terima_bpmk()
    {
        $recipient = $this->request->getPost('email');
        $nama = $this->request->getPost('nama');
        $subject = 'Pendaftaran Pengurus Biro Pelayanan Mahasiswa Kristen (BPMK)';

        try {
            $this->sendmail('Biro Pelayanan Mahasiswa Kristen', $recipient, $nama, $subject, true);
            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_pendaftaran_bpmk");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_pendaftaran_bpmk");
        }
    }

    public function tolak_bpmk()
    {
        $recipient = $this->request->getPost('email');
        $nama = $this->request->getPost('nama');
        $subject = 'Pendaftaran Pengurus Biro Pelayanan Mahasiswa Kristen (BPMK)';

        try {
            $this->sendmail('Biro Pelayanan Mahasiswa Kristen', $recipient, $nama, $subject, false);
            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_pendaftaran_bpmk");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_pendaftaran_bpmk");
        }
    }

    public function delete_bpmk()
    {
        $id = $this->request->getPost('id');
        $id_ukm = $this->request->getPost('idUkm');
        $currentFile = $this->request->getPost('current_file');
        try {
            $Model = new DaftarBpmkModel();
            $Model->delete($id);
            session()->setFlashdata('status', 'success');
            if (!empty($currentFile)) {
                $currentFilePath = ROOTPATH . 'assets/doc/' . $currentFile;
                if (file_exists($currentFilePath)) {
                    unlink($currentFilePath);
                }
            }
            return redirect()->to("/kelola_pendaftaran_bpmk/");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_pendaftaran_bpmk/");
        }
    }

    public function daftar_nnu()
    {
        helper(['form', 'url']);

        $Model = new DaftarNNUModel();

        if ($this->request->getFile('mahasiswa_aktif')->isValid()) {
            $filemahasiswa_aktif = $this->request->getFile('mahasiswa_aktif');
            $originalNamemahasiswa_aktif = $filemahasiswa_aktif->getName(); // Get the original filename
            $newNamemahasiswa_aktif = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalNamemahasiswa_aktif);
            $filemahasiswa_aktif->move(ROOTPATH . 'assets/doc', $newNamemahasiswa_aktif);
        }

        if ($this->request->getFile('penampilan')->isValid()) {
            $filepenampilan = $this->request->getFile('penampilan');
            $originalNamepenampilan = $filepenampilan->getName(); // Get the original filename
            $newNamepenampilan = $this->getUniqueFilename(ROOTPATH . 'assets/doc', $originalNamepenampilan);
            $filepenampilan->move(ROOTPATH . 'assets/doc', $newNamepenampilan);
        }

        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $mahasiswa_aktif = $this->request->getPost('mahasiswa_aktif');
        $semester = $this->request->getPost('semester');
        $cekpribadi = $this->request->getPost('pribadi');
        $cekwawasan = $this->request->getPost('wawasan');
        $bahasa_asing = $this->request->getPost('bahasa_asing');
        $cekbelum_menikah = $this->request->getPost('belum_menikah');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $tinggi = $this->request->getPost('tinggi');

        $pribadi = $cekpribadi === "on" ? 1 : 0;
        $wawasan = $cekwawasan === "on" ? 1 : 0;
        $belum_menikah = $cekbelum_menikah === "on" ? 1 : 0;

        $skor = 0;  //skor awal 0 poin
        $skor += $mahasiswa_aktif != 0 ? 20 : 0;  //kalo pendaftar upload bukti mahasiswa aktif, ta tambah 20 poin
        $skor += $semester < 7 ? 10 : 0;  //kalo pendaftar masih di bawah smester 7, ta tambah 10 poin
        $skor += $pribadi != 0 ? 10 : 0;   //kalo pendaftar centang berkepribadian baik, ta tambah 10 poin
        $skor += $wawasan != 0 ? 10 : 0;   //kalo pendaftar centang berwawasan luas, ta tambah 10 poin
        $skor += $bahasa_asing != null ? 20 : 0;  //kalo pendaftar isi bahasa asing, ta tambah 20 poin
        $skor += $belum_menikah != 0 ? 10 : 0;    //kalo pendaftar centang belum menikah, ta tambah 10 poin
        $skor += ($tinggi > 160 && $jenis_kelamin == 'Perempuan') || ($tinggi > 170 && $jenis_kelamin == 'Laki-laki') ? 20 : 0;  //kalo pendaftar isi tinggi lebih dari 160 for jenis kelamin perempuan, ato lebih dari 170 for jenis kelamin laki-laki, ta tambah 20 poin
        //total poin kalo isi samua: 100 poin

        try {
            $Model->insert([
                'email' => $email,
                'nama' => $nama,
                'mahasiswa_aktif' => $newNamemahasiswa_aktif,
                'semester' => $semester,
                'pribadi' => $pribadi,
                'wawasan' => $wawasan,
                'penampilan' => $newNamepenampilan,
                'bahasa_asing' => $bahasa_asing,
                'belum_menikah' => $belum_menikah,
                'jenis_kelamin' => $jenis_kelamin,
                'tinggi' => $tinggi,
                'skor' => $skor,
            ]);
            session()->setFlashdata('status', 'success');
            return redirect()->to("/hasil_daftar");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/hasil_daftar");
        }
    }

    public function kelola_pendaftaran_nnu()
    {
        $UkmModel = new DaftarNNUModel();
        $namaUkmModel = new UkmModel();
        $ukmNames = $namaUkmModel->findAll();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }

        $ukm = session()->get('ukm');

        $namaUkm = $namaUkmModel
            ->select('nama_ukm')
            ->where('id_ukm', 2)
            ->get()
            ->getRow('nama_ukm');

        if (session()->get('userRole') == 1) {
            $Data = $UkmModel->getKegiatanWithUkmName();
        } else {
            $Data = $UkmModel->getAll();
        }

        return view('kelola_pendaftaran_nnu', ['ukmNames' => $ukmNames, 'Data' => $Data, 'namaUkm' => $namaUkm, 'id_ukm' => $ukm]);
    }

    public function pendaftaran_nnu()
    {
        $namaUkmModel = new UkmModel();

        $ukmNames = $namaUkmModel->findAll();

        return view('formulir_NNU', ['ukmNames' => $ukmNames]);
    }

    public function terima_nnu()
    {
        $recipient = $this->request->getPost('email');
        $nama = $this->request->getPost('nama');
        $subject = 'Pendaftaran Pengurus Nyong Noni UNIMA';

        try {
            $this->sendmail('Nyong Noni UNIMA', $recipient, $nama, $subject, true);
            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_pendaftaran_nnu");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_pendaftaran_nnu");
        }
    }

    public function tolak_nnu()
    {
        $recipient = $this->request->getPost('email');
        $nama = $this->request->getPost('nama');
        $subject = 'Pendaftaran Pengurus Nyong Noni UNIMA';

        try {
            $this->sendmail('Nyong Noni UNIMA', $recipient, $nama, $subject, false);
            session()->setFlashdata('status', 'success');
            return redirect()->to("/kelola_pendaftaran_nnu");
        } catch (\Exception $e) {
            session()->setFlashdata('status', 'error');
            return redirect()->to("/kelola_pendaftaran_nnu");
        }
    }
}
