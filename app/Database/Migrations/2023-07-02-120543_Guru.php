<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Guru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_guru' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'unsigned'       => false,
            ],
            'nama_guru' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'tmp_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'tgl_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'jk' => [
                'type'       => 'ENUM',
                'constraint' => ['L','P'],
            ],
            'alamat' => [
                'type'       => 'TEXT',
                'null' => true,
            ],
            'notelp' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'null' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addKey('id_guru', true);
        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}
