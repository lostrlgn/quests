<?php

use yii\db\Migration;

class m251126_042120_create_quest_slots_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('quest_slots', [
            'id' => $this->primaryKey(),
            'quest_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'date' => $this->date()->notNull(),
            'time' => $this->time()->notNull(),
            'order_state' => $this->string()->notNull()->defaultValue('created'),
        ]);

        $this->addForeignKey(
            'fk_quest_slots_quest',
            'quest_slots',
            'quest_id',
            'quests',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_quest_slots_user',
            'quest_slots',
            'user_id',
            'users',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            'idx_unique_slot',
            'quest_slots',
            ['quest_id', 'date', 'time'],
            true
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_quest_slots_quest', 'quest_slots');
        $this->dropForeignKey('fk_quest_slots_user', 'quest_slots');
        $this->dropIndex('idx_unique_slot', 'quest_slots');
        $this->dropTable('quest_slots');
    }
}
