<?php
namespace App\Models;

use CodeIgniter\Model;

class DaftarNNUModel extends Model
{
    protected $table = 'calon_pengurus_nnu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'email', 'nama', 'mahasiswa_aktif', 'semester', 'pribadi', 'wawasan', 'penampilan', 'bahasa_asing', 'belum_menikah', 'jenis_kelamin', 'tinggi', 'skor'];

    public function getAll()
    {
        $this->select('calon_pengurus_nnu.*',);
        $this->orderBy('nama', 'ASC');

        return $this->findAll();
    }
}