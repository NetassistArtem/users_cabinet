<?php


namespace app\models;


use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\models\User;

class SkinsChangeForm extends Model
{

    public $skin;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [


        ];
    }

    public function setNewSkin()
    {

        if($this->validate()) {


           $this->newSkin();

           // die();

            Yii::$app->session->setFlash('messageSkinChanged', ['value' => Yii::t('flash-message', 'new_skin_saved')]);

        //    Yii::$app->session->set('selected_options', );



            return true;
        }else {


            Yii::$app->session->setFlash('messageSkinChanged', ['value' => Yii::t('flash-message', 'new_skin_not_saved')]);
            return false;
        }
    }

    public function newSkin()
    {
        $post_data = Yii::$app->request->post('SkinsChangeForm')['skin'];

        $skin_id = Yii::$app->params['skin_types'][$post_data]['billing_key'];

        set_skin(Yii::$app->user->identity->username, $skin_id);

        User::UserData();


        return '';
    }

}