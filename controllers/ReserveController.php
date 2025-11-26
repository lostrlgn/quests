<?php

namespace app\controllers;

use yii\rest\Controller;
use Yii;
use app\services\ReserveService;

class ReserveController extends Controller
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

    public function actionIndex($id)
    {
        $service = new ReserveService();

        $data = Yii::$app->request->post();
        $date = $data['date'] ?? null;
        $time = $data['time'] ?? null;

        $userId = Yii::$app->user->id;

        return $service->reserve($id, $date, $time, $userId);
    }
}
