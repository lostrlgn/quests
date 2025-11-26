<?php

namespace app\services;

use app\models\Quests;

class QuestService
{
    public function getAll()
    {
        return Quests::find()->all();
    }

    public function getOne($id)
    {
        return Quests::findOne(['id' => $id]);
    }
}
