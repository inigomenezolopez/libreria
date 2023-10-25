<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserdataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=> [
                "type"=> "INT",
                "unsigned"=>true,
                "auto_increment"=> true,
            ],
            "name" => [
                "type"=> "VARCHAR",
                "constraint"=>"255",
            ],
            "email"=> [
                "type"=>"VARCHAR",
                "constraint"=>"255",
            ],
            "password"=> [
                "type"=> "VARCHAR",
                "constraint"=>"255",
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addkey('id', true);
        $this->forge->addkey('name');
        $this->forge->createTable('userdata');
        }

    public function down()
    {
        $this->forge->dropTable('userdata');
    }
}