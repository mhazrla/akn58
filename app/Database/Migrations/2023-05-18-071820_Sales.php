<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sales extends Migration
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
            'sales_date'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'faktur_sale'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'qty'       => [
                'type'           => 'INT',
                'constraint'     => '4'
            ],
            'total_price'       => [
                'type' => 'double',
                'constraint' => '11,2',
            ],
            'product_id'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'cascade');
        $this->forge->createTable('sales', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('sales');
    }
}
