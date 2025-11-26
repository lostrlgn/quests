<?php

namespace app\controllers;

use yii\rest\Controller;
use Yii;
use app\services\QuestSlotsService;

class QuestSlotsController extends Controller
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

    public function actionView($id)
    {
        $service = new QuestSlotsService();

        $date = Yii::$app->request->get('date');

        return $service->getSlots($id, $date);
    }
}
