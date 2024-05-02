<?php
namespace App\Models;

use CodeIgniter\Model;

class DokumentasiModel extends Model
{
    protected $table = 'dokumentasi';
    protected $primaryKey = 'id_dokumentasi';
    protected $allowedFields = ['id_dokumentasi', 'id_ukm', 'tanggal_dokumentasi', 'file_name', 'keterangan'];

    public function getDokumentasiWithUkmName()
    {
        $this->select('dokumentasi.*, nama_ukm.nama_ukm');
        $this->join('nama_ukm', 'dokumentasi.id_ukm = nama_ukm.id_ukm', 'left');
        $this->orderBy('nama_ukm.nama_ukm', 'ASC');

        return $this->findAll();
    }
}