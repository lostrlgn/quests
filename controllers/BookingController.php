<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\services\BookingService;

class BookingController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        if (!$userId) {
            return [
                'status' => 'error',
                'message' => 'Необходимо войти в систему'
            ];
        }

        $service = new BookingService();
        $items = $service->getUserBookings($userId);

        return [
            'status' => 'ok',
            'items' => $items
        ];
    }

    public function actionCancel($id)
    {
        $userId = Yii::$app->user->id;

        if (!$userId) {
            return [
                'status' => 'error',
                'message' => 'Необходимо войти в систему'
            ];
        }

        $service = new BookingService();
        return $service->cancelBooking($id, $userId);
    }
}
