<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ComicInfo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=> [
                "type"=> "INT",
                "unsigned"=>true,
                "auto_increment"=> true,
            ],
            "title" => [
                "type"=> "VARCHAR",
                "constraint"=>"255",
            ],
            "year"=> [
                "type"=>"INT",
                
            ],
            "price"=> [
                "type"=>"INT",
            ],
            "category"=> [
                "type"=>"VARCHAR",
                "constraint"=>"255",
            ],
            "description"=> [
                "type"=>"text",
                
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);
        
        $this->forge->addkey('id', true);
        $this->forge->addkey('title');
        $this->forge->addkey('price');
        $this->forge->addkey('category');
        $this->forge->createTable('comic_info');
        
        }
    

    public function down()
    {
        $this->forge->dropTable('comic_info');
    }
}
