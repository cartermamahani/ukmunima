<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table = 'calon_pengurus'; // Nama tabel dalam database

    protected $primaryKey = 'id'; // Primary key tabel

    protected $allowedFields = ['nama', 'nim', 'terlibat_pelayanan', 'memahami_pdp', 'student_bible_meeting', 'tidak_menjabat', 'dimuridkan', 'aktiv_kuliah']; // Field yang dapat diisi oleh pengguna

    // Fungsi untuk menyimpan data pendaftaran ke database
    public function savePendaftaran($data)
    {
        return $this->insert($data);
    }

    // Fungsi lain yang mungkin Anda perlukan, seperti mengambil data pendaftaran, menghapus data, dll.
}
