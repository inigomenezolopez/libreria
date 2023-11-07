<?php

namespace App\Models;

use CodeIgniter\Model;

class Category extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'category_info';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['category'];

    public function getCategories()
    {
        return $this->findAll();
    }
}
