<?php

namespace app\controllers;

use yii\rest\Controller;
use Yii;
use app\services\AuthService;

class AuthController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actionRegister()
    {
        $service = new AuthService();
        $data = Yii::$app->request->post();

        return $service->register($data);
    }

    public function actionLogin()
    {
        $service = new AuthService();
        $data = Yii::$app->request->post();

        return $service->login($data['email'], $data['password_hash']);
    }
}
