<?php
namespace App\Models;

use CodeIgniter\Model;

class LpjModel extends Model
{
    protected $table = 'lpj';
    protected $primaryKey = 'id_lpj';
    protected $allowedFields = [
        'nama_bidang', 'file', 'content_type', 'file_name', 'judul', 'tanggal_periode_lpj', 'keterangan', 'id_ukm'
    ];


    public function getLpjWithUkmName()
    {
        $this->select('lpj.*, nama_ukm.nama_ukm');
        $this->join('nama_ukm', 'lpj.id_ukm = nama_ukm.id_ukm', 'left');
        $this->orderBy('nama_ukm.nama_ukm', 'ASC');

        return $this->findAll();
    }
}