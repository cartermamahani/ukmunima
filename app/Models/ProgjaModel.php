<?php
namespace App\Models;

use CodeIgniter\Model;

class ProgjaModel extends Model
{
    protected $table = 'progja';
    protected $primaryKey = 'id_progja';
    protected $allowedFields = [
        'nama_bidang', 'file_name', 'nama_progja', 'tanggal_progja', 'keterangan', 'id_ukm'
    ];

    public function getProgjaWithUkmName()
    {
        $this->select('progja.*, nama_ukm.nama_ukm');
        $this->join('nama_ukm', 'progja.id_ukm = nama_ukm.id_ukm', 'left');
        $this->orderBy('nama_ukm.nama_ukm', 'ASC');

        return $this->findAll();
    }
}