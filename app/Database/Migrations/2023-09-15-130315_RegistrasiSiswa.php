<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RegistrasiSiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_registrasi' => [
                'type'  => 'VARCHAR',
                'constraint' => 36,
                'unsigned'  => false,
            ],
            'id_santri' => [
                'type' => 'VARCHAR',
                'constraint' => 36
            ],
            'id_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null'      => true
            ],
            'id_pesantren' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null'      => true
            ],
            'kelas_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null'       => true
            ],
            'kelas_pesantren' => [
                'type' => 'VARCHAR',
                'constraint' => 36
            ],
            'id_tahun' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
            ],
            'nis'   => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true
            ],
            'status' => [
                'type'           => 'ENUM',
                'constraint'     => ['1','0'],
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
        $this->forge->addKey('id_registrasi',true);
        $this->forge->addForeignKey('id_santri','santri','id_santri');
        $this->forge->addForeignKey('id_tahun','tahun','id_tahun');
        $this->forge->addForeignKey('id_sekolah','lembaga','id_lembaga');
        $this->forge->addForeignKey('id_pesantren','lembaga','id_lembaga');
        $this->forge->addForeignKey('kelas_sekolah','kelas','id_kelas');
        $this->forge->addForeignKey('kelas_pesantren','kelas','id_kelas');
        $this->forge->createTable('regis_siswa');
    }

    public function down()
    {
        $this->forge->dropTable('regis_siswa');
    }
}
