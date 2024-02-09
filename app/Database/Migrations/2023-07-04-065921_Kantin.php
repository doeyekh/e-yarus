<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kantin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kantin' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
            ],
            'nama_kantin' => [
                'type'       => 'VARCHAR',
                'constraint' => '160',
            ],
            'username' => [
                'type'      => 'VARCHAR',
                'constraint' => '100'
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['1','2','3'],
            ],
            'is_active' => [
                'type'       => 'ENUM',
                'constraint' => ['1','0'],
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id_kantin', true);
        $this->forge->createTable('kantin');
    }
    public function down()
    {
        $this->forge->dropTable('kantin');
    }
}
