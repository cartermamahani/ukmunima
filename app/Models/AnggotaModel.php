<?php
namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $allowedFields = [
        'nim', 'nama_mahasiswa', 'fakultas', 'jurusan', 'alamat', 'tempat_lahir', 'tanggal_lahir', 'id_ukm'
    ];
    
    public function getAnggota()
    {
        $this->select('anggota.*, nama_ukm.nama_ukm');
        $this->join('nama_ukm', 'anggota.id_ukm = nama_ukm.id_ukm', 'left');
        $this->orderBy('nama_ukm.nama_ukm', 'ASC');

        return $this->findAll();
    }
}