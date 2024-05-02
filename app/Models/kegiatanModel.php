<?php
namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'id_ukm', 'waktu', 'judul', 'keterangan', 'file_name'];

    public function getKegiatanWithUkmName()
    {
        $this->select('kegiatan.*, nama_ukm.nama_ukm');
        $this->join('nama_ukm', 'kegiatan.id_ukm = nama_ukm.id_ukm', 'left');
        $this->orderBy('nama_ukm.nama_ukm', 'ASC');

        return $this->findAll();
    }
}