<?php

namespace App\Models;
use CodeIgniter\Model;

class RegistroModel extends Model {
    protected $table      = 'userdata';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'email', 'password'];

    // Dates
    protected $useTimestamps = false;

}
