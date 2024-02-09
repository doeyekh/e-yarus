<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alumni extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alumni' => [
                'type'  => 'VARCHAR',
                'constraint' => 36,
                'unsigned'  => false,
            ],
            'id_santri' => [
                'type' => 'VARCHAR',
                'constraint' => 36
            ],
            'tgl_keluar' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null'      => true
            ],
            'alasan' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null'      => true
            ],
            'tujuan' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null'      => true
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
        $this->forge->addKey('id_alumni',true);
        $this->forge->addForeignKey('id_santri','santri','id_santri');
        $this->forge->createTable('alumni');
    }

    public function down()
    {
        $this->forge->dropTable('alumni');
    }
}
