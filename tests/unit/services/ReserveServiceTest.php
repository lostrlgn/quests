<?php

namespace tests\unit\services;

use app\models\Quests;
use app\models\QuestSlots;
use app\services\ReserveService;
use Yii;

class ReserveServiceTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        // Чистим таблицы перед каждым тестом
        QuestSlots::deleteAll();
        Quests::deleteAll();
    }

    /** @test */
    public function slot_not_found()
    {
        $service = new ReserveService();

        $result = $service->reserve(1, '2025-01-01', '10:00', 5);

        $this->assertEquals('Слот не найден', $result['error']);
    }

    /** @test */
    public function slot_already_reserved()
    {
        $slot = new QuestSlots([
            'quest_id' => 1,
            'date' => '2025-01-01',
            'time' => '10:00',
            'user_id' => 99,
        ]);
        $slot->save(false);

        $service = new ReserveService();

        $result = $service->reserve(1, '2025-01-01', '10:00', 5);

        $this->assertEquals('Слот уже зарезервирован', $result['error']);
    }

    /** @test */
    public function quest_not_found()
    {
        $slot = new QuestSlots([
            'quest_id' => 1,
            'date' => '2025-01-01',
            'time' => '10:00',
            'user_id' => null,
        ]);
        $slot->save(false);

        $service = new ReserveService();

        $result = $service->reserve(1, '2025-01-01', '10:00', 5);

        $this->assertEquals('Квест не найден', $result['error']);
    }

    /** @test */
    public function quest_closed_at_this_time()
    {
        $quest = new Quests([
            'id' => 1,
            'work_hours_from' => '12:00',
            'work_hours_to' => '20:00',
        ]);
        $quest->save(false);

        $slot = new QuestSlots([
            'quest_id' => 1,
            'date' => '2025-01-01',
            'time' => '10:00',
            'user_id' => null,
        ]);
        $slot->save(false);

        $service = new ReserveService();

        $result = $service->reserve(1, '2025-01-01', '10:00', 5);

        $this->assertEquals('Квест не работает в это время', $result['error']);
    }

    /** @test */
    public function user_already_reserved_same_time()
    {
        $quest = new Quests([
            'id' => 1,
            'work_hours_from' => '08:00',
            'work_hours_to' => '22:00',
        ]);
        $quest->save(false);

        // слот, на который резервируем
        $slot = new QuestSlots([
            'quest_id' => 1,
            'date' => '2025-01-01',
            'time' => '10:00',
            'user_id' => null,
        ]);
        $slot->save(false);

        // пользователь уже занят на это же время
        $busySlot = new QuestSlots([
            'quest_id' => 2,
            'date' => '2025-01-01',
            'time' => '10:00',
            'user_id' => 5,
        ]);
        $busySlot->save(false);

        $service = new ReserveService();

        $result = $service->reserve(1, '2025-01-01', '10:00', 5);

        $this->assertEquals('Пользователь уже зарезервирован на это время', $result['error']);
    }

    /** @test */
    public function successful_reservation()
    {
        $quest = new Quests([
            'id' => 1,
            'work_hours_from' => '08:00',
            'work_hours_to' => '22:00',
        ]);
        $quest->save(false);

        $slot = new QuestSlots([
            'quest_id' => 1,
            'date' => '2025-01-01',
            'time' => '10:00',
            'user_id' => null,
        ]);
        $slot->save(false);

        $service = new ReserveService();

        $result = $service->reserve(1, '2025-01-01', '10:00', 123);

        $this->assertArrayHasKey('slot', $result);
        $this->assertEquals(123, $result['slot']->user_id);
        $this->assertEquals('created', $result['slot']->order_state);
    }
}
