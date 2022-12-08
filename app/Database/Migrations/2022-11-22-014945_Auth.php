<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Auth extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ], 'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ], 'username_user' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ], 'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ], 'user_image' => [
                'type' => 'text',
                'default' => 'default.jpg', 'null' => true,
            ],
            'daftar_waktu' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);

        $this->forge->addUniqueKey('email');
        $this->forge->addPrimaryKey('id_user', true);
        $this->forge->createTable('auth', true);
    }

    public function down()
    {
        $this->forge->dropTable('auth', true);
    }
}
