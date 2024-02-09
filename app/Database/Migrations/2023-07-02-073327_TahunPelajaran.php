<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TahunPelajaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tahun' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
            ],
            'tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
            ],
            'akademik' => [
                'type'       => 'VARCHAR',
                'constraint' => '14',
            ],
            'smt' => [
                'type'       => 'ENUM',
                'constraint' => ['Ganjil','Genap'],
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' =>['1','0']
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
        $this->forge->addKey('id_tahun', true);
        $this->forge->createTable('tahun');
    }

    public function down()
    {
        $this->forge->dropTable('tahun');
    }
}
