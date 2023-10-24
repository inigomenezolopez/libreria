<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            "name"=> 'Admin',
            "email"=> 'admin@email.com',
            "password"=> '12345',
        );
        $this->db->table('userdata')->insert($data);
    }
}
