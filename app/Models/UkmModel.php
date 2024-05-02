<?php

namespace App\Models;

use CodeIgniter\Model;

class UkmModel extends Model
{
    protected $table = 'nama_ukm';
    protected $primaryKey = 'id_ukm';
    protected $allowedFields = [
        'nama_ukm', 'logo_ukm', 'keterangan_ukm', 'visi', 'misi', 'email', 'nomor_hp', 'foto_struktur'
    ];
}
