<?php
namespace App\Models;

use CodeIgniter\Model;

class DaftarBpmkModel extends Model
{
    protected $table = 'calon_pengurus_bpmk';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'email', 'nama', 'aktiv_pelayanan', 'pdp', 'sbm', 'organisasi', 'muridkan', 'aktiv_kuliah', 'skor'];

    public function getAll()
    {
        $this->select('calon_pengurus_bpmk.*',);
        $this->orderBy('nama', 'ASC');

        return $this->findAll();
    }
}