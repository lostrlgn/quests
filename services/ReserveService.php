<?php

namespace app\services;

use app\models\Quests;
use app\models\QuestSlots;

class ReserveService
{
    public function reserve($questId, $date, $time, $userId)
    {
        $slot = QuestSlots::findOne([
            'quest_id' => $questId,
            'date' => $date,
            'time' => $time,
        ]);

        if (!$slot) {
            return ['error' => 'Слот не найден'];
        }

        if ($slot->user_id !== null) {
            return ['error' => 'Слот уже зарезервирован'];
        }

        $quest = Quests::findOne($questId);
        if (!$quest) {
            return ['error' => 'Квест не найден'];
        }

        if (strtotime($time) < strtotime($quest->work_hours_from)
            || strtotime($time) > strtotime($quest->work_hours_to)
        ) {
            return ['error' => 'Квест не работает в это время'];
        }

        $busy = QuestSlots::find()
            ->where(['user_id' => $userId, 'date' => $date, 'time' => $time])
            ->one();

        if ($busy) {
            return ['error' => 'Пользователь уже зарезервирован на это время'];
        }

        $slot->user_id = $userId;
        $slot->order_state = 'created';
        $slot->save(false);

        return ['slot' => $slot];
    }
}
