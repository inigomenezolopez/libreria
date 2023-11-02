<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransInfo extends Seeder
{
    public function run()
    {
        $data = array(
            "email"=> 'admin@email.com',
            "title"=> "BORUTO Nº 19",
            "price"=> 8.07,
        );
        $this->db->table('trans_info')->insert($data);
    }
}
