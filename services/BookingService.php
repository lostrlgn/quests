<?php

namespace app\services;

use app\models\QuestSlots;

class BookingService
{
    public function getUserBookings($userId)
    {
        return QuestSlots::find()
            ->where(['user_id' => $userId])
            ->orderBy(['date' => SORT_ASC, 'time' => SORT_ASC])
            ->asArray()
            ->all();
    }


    public function cancelBooking($id, $userId)
    {
        $slot = QuestSlots::findOne([
            'id' => $id,
            'user_id' => $userId
        ]);

        if (!$slot) {
            return [
                'status' => 'error',
                'message' => 'Бронь не найдена'
            ];
        }

        $slot->user_id = null;
        $slot->order_state = 'cancelled';
        $slot->save(false);

        return [
            'status' => 'ok',
            'message' => 'Бронь отменена!'
        ];
    }
}
