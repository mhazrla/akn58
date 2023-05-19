<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'nama'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'stok'       => [
                'type'           => 'INT',
                'constraint'     => '4'
            ],
            'harga_beli'       => [
                'type' => 'double',
                'constraint' => '11,2',
                'default' => 0.00
            ],
            'harga_jual'       => [
                'type' => 'double',
                'constraint' => '11,2',
                'default' => 0.00
            ],
            'category_id'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'cascade');
        $this->forge->createTable('products', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
