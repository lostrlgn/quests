<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use app\services\QuestService;

class QuestController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actionIndex()
    {
        $service = new QuestService();
        return $service->getAll();
    }

    public function actionView($id)
    {
        $service = new QuestService();
        return $service->getOne($id);
    }
}
