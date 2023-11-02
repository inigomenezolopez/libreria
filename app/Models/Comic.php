<?php

namespace App\Models;

use CodeIgniter\Model;

class Comic extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'comic_info';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['title', 'picture', 'year', 'price', 'category', 'description'];

}