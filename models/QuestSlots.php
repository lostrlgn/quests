<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quest_slots".
 *
 * @property int $id
 * @property int $quest_id
 * @property int|null $user_id
 * @property string $date
 * @property string $time
 * @property string $order_state
 *
 * @property Quests $quest
 * @property Users $user
 */
class QuestSlots extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quest_slots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quest_id', 'date', 'time'], 'required'],
            [['quest_id', 'user_id'], 'integer'],
            [['date', 'time'], 'safe'],
            [['order_state'], 'string'],
            [['quest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quests::class, 'targetAttribute' => ['quest_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quest_id' => 'Quest ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'time' => 'Time',
            'order_state' => 'Order State',
        ];
    }

    /**
     * Gets query for [[Quest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuest()
    {
        return $this->hasOne(Quests::class, ['id' => 'quest_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
