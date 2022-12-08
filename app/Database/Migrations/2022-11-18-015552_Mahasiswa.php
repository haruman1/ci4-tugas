<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mahasiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ], 'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ], 'nim' => [
                'type' => 'char',
                'constraint' => '7',
            ], 'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ], 'user_image' => [
                'type' => 'text',
                'default' => 'default.jpg', 'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('nim');

        $this->forge->createTable('mahasiswa', true);
    }

    public function down()
    {
        $this->forge->dropTable('mahasiswa', true);
    }
}
