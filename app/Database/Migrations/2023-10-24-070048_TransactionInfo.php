<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionInfo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "unsigned" => true,
                "auto_increment" => true,
            ],
            "email" => [
                "type" => "VARCHAR",
                "constraint" => "255",
            ],
            "title" => [
                "type" => "VARCHAR",
                "constraint" => "255",
            ],
            "price" => [
                "type" => "FLOAT",
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addkey('id', true);

        $this->forge->createTable('trans_info');
    }

    public function down()
    {
        $this->forge->dropTable('trans_info');
    }
}
