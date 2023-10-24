<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CategoryInfo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=> [
                "type"=> "INT",
                "unsigned"=>true,
                "auto_increment"=> true,
            ],
            "category" => [
                "type"=> "VARCHAR",
                "constraint"=>"255",
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addkey('id', true);
        $this->forge->addkey('category');
        $this->forge->createTable('category_info');
        }

    public function down()
    {
        $this->forge->dropTable('category_info');
    }
}
