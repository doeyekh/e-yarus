<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataOrtu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ortu' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'unsigned'       => false,
            ],
            'nama_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 300,
            ],
            'nik_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 16
            ],
            'pekerjaan_ayah' => [
                'type'  => 'VARCHAR',
                'constraint' => 300,
                'null' => true,
            ],
            'notelp_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 16
            ],
            'nama_ibu' => [
                'type'  => 'VARCHAR',
                'constraint' => 16
            ],
            'nik_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 16
            ],
            'pekerjaan_ibu' => [
                'type'  => 'VARCHAR',
                'constraint' => 300,
                'null' => true,
            ],
            'notelp_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 16
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id_ortu',true);
        $this->forge->createTable('ortu');
    }

    public function down()
    {
        $this->forge->dropTable('ortu');
    }
}
