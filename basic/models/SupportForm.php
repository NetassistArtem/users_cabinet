<?php


namespace app\models;


use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use yii\web\Controller;
use app\components\sms_handler\UserSms;

class SupportForm extends Model
{

    public $problem;


    /**
     * @return array the validation rules.
     */



    public function rules()
    {
        return [

            [['problem'], 'required'],

        ];
    }

    public function sendProblem()
    {
        // $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];


        if ($this->validate()) {

            $this->selectProblem();
           // Yii::$app->session->setFlash('selectProblem', ['value' => Yii::t('flash-message', 'selected_problem')]);
            //$this->insertNewPhone1();
            return true;
        } else {
            Yii::$app->session->setFlash('selectProblem', ['value' => Yii::t('flash-message', 'unselected_problem')]);
            return false;
        }
    }



    private function selectProblem()
    {


        $problem = Yii::$app->request->post('SupportForm')['problem'];
        Yii::$app->session->set('problem', $problem);

    }

}