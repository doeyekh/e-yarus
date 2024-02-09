<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Santri extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_santri' => [
                'type'  => 'VARCHAR',
                'constraint' => 36,
                'unsigned'  => false,
            ],
            'id_ortu' => [
                'type' => 'VARCHAR',
                'constraint' => 36
            ],
            'nama_santri' => [
                'type' => 'VARCHAR',
                'constraint' => 250
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => 16
            ],
            'jk' => [
                'type'  => 'ENUM',
                'constraint' => ['L','P']
            ],
            'tmp_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'tgl_lahir' => [
                'type' => 'DATE',
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'rt' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'rw' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'desa' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'kec' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'kab' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'prov' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'berkas' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 50
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
        $this->forge->addKey('id_santri',true);
        $this->forge->addForeignKey('id_ortu','ortu','id_ortu');
        $this->forge->createTable('santri');
    }

    public function down()
    {
        $this->forge->dropTable('santri');
    }
}
