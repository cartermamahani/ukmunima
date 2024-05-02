<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'login';
    
    protected $allowedFields = [
        'nama_admin',
        'username',
        'password',
        'level_admin',
        'id_ukm'
    ];
}
