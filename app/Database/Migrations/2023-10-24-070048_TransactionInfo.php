<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionInfo extends Migration
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
            "title"=> [
                "type"=> "VARCHAR",
                "constraint"=>"255",
            ],
            "price"=> [
                "type"=>"FLOAT",
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);
        
        $this->forge->addkey('id', true);
        $this->forge->addkey('name');
        $this->forge->addkey('title');
        $this->forge->addkey('price');
        $this->forge->addForeignKey('name','userdata','name','CASCADE','CASCADE');
        $this->forge->addForeignKey('title','comic_info','title','CASCADE','CASCADE');
        $this->forge->addForeignKey('price','comic_info','price','CASCADE','CASCADE');
        $this->forge->createTable('trans_info');
        
        }

    public function down()
    {
        $this->forge->dropTable('trans_info');
    }
}
