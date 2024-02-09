<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelasSiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas' => [
                'type'  => 'VARCHAR',
                'constraint' => 36,
                'unsigned'  => false,
            ],
            'id_lembaga' => [
                'type' => 'VARCHAR',
                'constraint' => 36
            ],
            'id_tahun' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
            ],
            'id_guru' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,

            ],
            'level' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true
            ],
            'nama_kelas' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
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
        $this->forge->addKey('id_kelas',true);
        $this->forge->addForeignKey('id_tahun','tahun','id_tahun');
        $this->forge->addForeignKey('id_lembaga','lembaga','id_lembaga');
        $this->forge->addForeignKey('id_guru','guru','id_guru');
        $this->forge->createTable('kelas');
    }

    public function down()
    {
       $this->forge->dropTable('kelas');
    }
}
