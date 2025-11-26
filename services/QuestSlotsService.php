<?php

namespace app\services;

use app\models\QuestSlots;

class QuestSlotsService
{
    public function getSlots($questId, $date)
    {
        return QuestSlots::find()
            ->where([
                'quest_id' => $questId,
                'date' => $date
            ])
            ->asArray()
            ->all();
    }
}
