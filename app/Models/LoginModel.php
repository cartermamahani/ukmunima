<?php
namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'login';
    protected $primaryKey = 'id_admin';

    protected $allowedFields = [
        'id_admin', 'id_ukm', 'nama_admin', 'username', 'password', 'level_admin'
    ];
}
