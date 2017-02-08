<?php


namespace app\controllers;

use app\models\PhoneFirstChangeConfirmForm;
use Yii;
use app\components\debugger\Debugger;
use yii\web\Controller;


class PopapController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }




}