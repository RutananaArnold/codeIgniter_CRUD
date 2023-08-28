<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'body' => [
                'type' => 'VARCHAR',
                'constraint' => '300',
            ],
            'ownerId' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => '6',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'constraint' => '6',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'constraint' => '6',
            ],
        ]);
        $this->forge->addKey('id', true);
        // Add a foreign key constraint
        $this->forge->addForeignKey('ownerId', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
