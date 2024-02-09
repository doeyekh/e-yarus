<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KartuSantri extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kartu' => [
                'type'  => 'VARCHAR',
                'constraint' => 36,
                'unsigned'  => false,
            ],
            'id_santri' => [
                'type' => 'VARCHAR',
                'constraint' => 36
            ],
            'rfid' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null'      => true
            ],
            'nocard' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null'      => true
            ],
            'qrcode' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null'      => true
            ],
            'password' => [
                'type'          => 'VARCHAR',
                'constraint'    => 250
            ],
            'status' => [
                'type'          => 'ENUM',
                'constraint'    => ['0','1','2','3']
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
        $this->forge->addKey('id_kartu',true);
        $this->forge->addForeignKey('id_santri','santri','id_santri');
        $this->forge->createTable('kartusantri');
    }

    public function down()
    {
        $this->forge->dropTable('kartusantri');
    }
}
