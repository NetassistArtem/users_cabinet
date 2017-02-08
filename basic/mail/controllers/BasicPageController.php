<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\debugger\Debugger;
use app\models\BasicPage;
use yii\web\NotFoundHttpException;

class BasicPageController extends Controller
{


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionTest()
    {
        return $this->render('test');
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = BasicPage::findOne($id)) !== null) {
           // Debugger::Eho($model->title);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
