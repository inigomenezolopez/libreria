<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ComicInfo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "unsigned" => true,
                "auto_increment" => true,
            ],
            "title" => [
                "type" => "VARCHAR",
                "constraint" => "255",
            ],
            "picture" => [
                "type" => "VARCHAR",
                "constraint" => "255",
                "null" => true,
            ],
            "year" => [
                "type" => "INT",

            ],
            "price" => [
                "type" => "FLOAT",
            ],
            "category" => [
                "type" => "VARCHAR",
                "constraint" => "255",
            ],
            "description" => [
                "type" => "text",

            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addkey('id', true);
        $this->forge->addkey('title');
        $this->forge->addkey('price');
        $this->forge->addkey('category');
        $this->forge->createTable('comic_info');
        $this->forge->addForeignKey('category', 'category_info', 'category', 'CASCADE', 'CASCADE');
    }


    public function down()
    {
        $this->forge->dropTable('comic_info');
    }
}
