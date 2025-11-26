<?php

use yii\db\Migration;

class m251126_042118_create_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull(),
        ]);

        $this->createIndex('idx_users_email', 'users', 'email', true);
        $this->createIndex('idx_users_token', 'users', 'access_token', true);
    }

    public function safeDown()
    {
        $this->dropTable('users');
    }
}
