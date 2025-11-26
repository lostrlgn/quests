<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Quests".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $work_hours_from
 * @property string $work_hours_to
 * @property int $quest_duration
 *
 * @property QuestSlots[] $questSlots
 */
class Quests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'work_hours_from', 'work_hours_to', 'quest_duration'], 'required'],
            [['description'], 'string'],
            [['work_hours_from', 'work_hours_to'], 'safe'],
            [['quest_duration'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'work_hours_from' => 'Work Hours From',
            'work_hours_to' => 'Work Hours To',
            'quest_duration' => 'Quest Duration',
        ];
    }

    /**
     * Gets query for [[QuestSlots]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestSlots()
    {
        return $this->hasMany(QuestSlots::class, ['quest_id' => 'id']);
    }
}
