<?php

namespace App\Models;

use CodeIgniter\Model;

class TransInfo extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'trans_info';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['email, title, price'];

   
}
