<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataLembaga extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lembaga' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
            ],
            'id_guru' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama_lembaga' => [
                'type'       => 'VARCHAR',
                'constraint' => '160',
            ],
            'jenis' => [
                'type'       => 'ENUM',
                'constraint' => ['1','2'],
            ],
            'jenjang' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'alamat' => [
                'type'       => 'TEXT',
                'null' => true,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addKey('id_lembaga', true);
        $this->forge->addForeignKey('id_guru','guru','id_guru');
        $this->forge->createTable('lembaga');
    }

    public function down()
    {
        $this->forge->dropTable('lembaga');
    }
}
