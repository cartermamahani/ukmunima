<?php
namespace App\Models;

use CodeIgniter\Model;

class PrestasiUkmModel extends Model
{
    protected $table = 'prestasi_ukm';
    protected $primaryKey = 'id_prestasi';
    protected $allowedFields = ['nama_ukm', 'nama_prestasi', 'tanggal_prestasi'];
}
