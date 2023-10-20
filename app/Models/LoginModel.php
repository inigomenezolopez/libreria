<?php

namespace App\Models;
use CodeIgniter\Model;

class LoginModel extends Model {
    protected $table      = 'userdata';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'name', 'email', 'password'];

    // Dates
    protected $useTimestamps = false;

}
