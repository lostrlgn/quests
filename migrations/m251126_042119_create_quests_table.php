<?php

use yii\db\Migration;

class m251126_042119_create_quests_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('quests', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'work_hours_from' => $this->time()->notNull(),
            'work_hours_to' => $this->time()->notNull(),
            'quest_duration' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('quests');
    }
}
