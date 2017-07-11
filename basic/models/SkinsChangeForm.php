<?php


namespace app\models;


use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\models\User;

class SkinsChangeForm extends Model
{

    public $skin;
    public  $skinLang;

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
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $post_data = Yii::$app->request->post('SkinsChangeForm');

        $this->langSkin($user_data, $post_data);

        $post_data_skin = $post_data['skin'];

        $skin_id = Yii::$app->params['skin_types'][$post_data_skin]['billing_key'];

        set_skin(Yii::$app->user->identity->username, $skin_id);

        User::UserData();


        return '';
    }
    public function langSkin($user_data,$post_data)
    {
        $billing_lang_id = Yii::$app->params['lang'][$post_data['skinLang']]['id_billing'];
        //   Debugger::EhoBr($post_data['messageLang']);
        //   Debugger::VarDamp($billing_lang_id);
        // Debugger::EhoBr($user_data['message_lang']);

        if($user_data['skin_lang_billing_id'] != $billing_lang_id ){

            set_skin_lang($user_data['username'],$billing_lang_id);//функция биллинга, устанавливает язык рассылки
            // Debugger::EhoBr(get_skin_lang("*".$user_data['account_name']));
            //   Debugger::testDie();

              event_log2('common.lang.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $user_data['loc_id'], -1, -1,-1,-1, 'Change user lang');//функция биллинга записывает инфу в лог
        }
    }

}